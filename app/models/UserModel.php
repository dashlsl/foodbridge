<?php

namespace App\Models;

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

use PDO;
use App\Models\DatabaseModel;
use App\Models\SessionModel;
use App\Models\ValidateModel;

class UserModel
{
    /** Register user */
    public function register($role, $name, $email, $password, $phone)
    {
        $errors = $this->validateRegister( $role,$name, $email, $password, $phone);
        if (count($errors) > 0) {
            return $errors;
        }

        $password = $this->encryptPwd($password);

        // Insert to user table
        $sql = <<<SQL
            INSERT INTO 
                users (role, name, email, password, phone) 
            VALUES 
                (:role, :name, :email, :password, :phone)
        SQL;

        $params = [
            ':role' => $role,
            ':name' => $name,
            ':email' => $email,
            ':password' => $password,
            ':phone' => $phone
        ];
        
        DatabaseModel::exec($sql, $params);

        $userId = DatabaseModel::connect()->lastInsertId();

        return true;
    }

    /** Validate registration */
    private function validateRegister($role, $name, $email, $password, $phone)
    {
        $errors = [];

        if (!in_array($role, ['donor', 'volunteer', 'receiver'])) {
            $errors['role'] = "Invalid role provided.";
        }
        
        if (empty($name)) {
            $errors['name'] = '*Required';
        }

        if (empty($email)) {
            $errors['email'] = '*Required';
        }

        if (empty($password)) {
            $errors['password'] = '*Required';
        }

        if (empty($phone)) {
            $errors['phone'] = '*Required';
        }

        if (!ValidateModel::validateEmail($email) && !isset($errors['email'])) {
            $errors['email'] = '*Invalid email format';
        }
        
        if ($this->verifyEmail($email) && !isset($errors['email'])) {
            $errors['email'] = '*Email already registered';
        }
        
        if (!ValidateModel::validatePassword($password) && !isset($errors['password'])) {
            $errors['password'] = '*Invalid password format';
        }

        if (!ValidateModel::validatePhone($phone) && !isset($errors['phone'])) {
            $errors['phone'] = '*Invalid phone number format';
        }

        return $errors;
    }

    /** Login user
     * Validate email
     * Verify password using email
     */
    public function login($email, $password)
    {
        $errors = $this->validateLogin($email, $password);

        if (count($errors) > 0) {
            return $errors;
        }

        $sql = <<<SQL
            SELECT user_id FROM user WHERE email = :email LIMIT 1
        SQL;

        $params = [
            ':email' => $email
        ];


        $id = DatabaseModel::exec($sql, $params)->fetchColumn();
        $role = $this->getRoleById($id);
        SessionModel::setSession($id, $role);

        return true;
    }

    /** Validate login */
    private function validateLogin($email, $password)
    {
        $errors = [];

        if (empty($email)) {
            $errors['email'] = '*Required';
        }

        if (empty($password)) {
            $errors['password'] = '*Required';
        }

        if (!ValidateModel::validateEmail($email) && !isset($errors['email'])) {
            $errors['email'] = '*Invalid email format';
        }

        if (!$this->verifyEmail($email) && !isset($errors['email'])) {
            $errors['email'] = '*Email not registered';
        }

        if (!$this->verifyPwd($email, $password) && !isset($errors['password']) && !isset($errors['email'])) {
            $errors['password'] = '*Incorrect password';
        }

        return $errors;
    }

    /** Encrypt password */
    private function encryptPwd($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /** Verify password */
    private function verifyPwd($email, $password)
    {
        $sql = <<<SQL
            SELECT password FROM user WHERE email = :email
        SQL;

        $params = [
            ':email' => $email
        ];

        $hash = DatabaseModel::exec($sql, $params)->fetchColumn();

        return password_verify($password, $hash);
    }

    /** Verify if email is already registered */
    private function verifyEmail($email)
    {
        $sql = <<<SQL
            SELECT email FROM user WHERE email = :email
        SQL;

        $params = [
            ':email' => $email
        ];

        return DatabaseModel::exec($sql, $params)->rowCount() > 0;
    }

    /** Validate login status */
    public function validateLoginStatus()
    {    
        // Check if the session variables for user are set
        if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
            // Session is valid, the user is logged in
            return true;
        }
    
        // If session is not set or expired, return false
        return false;
    }

    /** Logout user */
    public function logout()
    {
        SessionModel::handleLogout();
    }

    /** Update user profile */
    public function updateProfile($userId, $name)
    {
        $errors = $this->validateUpdateProfile($name,);

        if (count($errors) > 0) {
            return $errors;
        }

        $sql = <<<SQL
            UPDATE 
                users
            SET
                name = :name
            WHERE
                user_id = :userId
        SQL;

        $params = [
            ':name' => $name,
            ':userId' => $userId
        ];

        DatabaseModel::exec($sql, $params);
        return true;
    }

    /** Validate update profile */
    public function validateUpdateProfile($name)
    {
        $errors = [];

        if (empty($name)) {
            $errors['name'] = '*Required';
        }

        return $errors;
    }

    /** Update user password */
    public function updatePwd($userId, $currentPwd, $newPwd, $confirmPwd)
    {
        $currentEmail = $this->getCurUserEmail();
        $errors = $this->validateUpdatePwd($currentEmail, $currentPwd, $newPwd, $confirmPwd);

        if (count($errors) > 0) {
            return $errors;
        }

        $newPwd = $this->encryptPwd($newPwd);

        $sql = <<<SQL
            UPDATE 
                users
            SET
                password = :newPwd
            WHERE
                user_id = :userId
        SQL;

        $params = [
            ':newPwd' => $newPwd,
            ':userId' => $userId
        ];

        DatabaseModel::exec($sql, $params);
        return true;
    }

    /**
     * Validate update user password
     */
    public function validateUpdatePwd($email, $curPwd, $newPwd, $confPwd)
    {
        $errors = [];

        if (empty($curPwd)) {
            $errors['curPwd'] = '*Required';
        }

        if (empty($newPwd)) {
            $errors['newPwd'] = '*Required';
        }

        if (empty($confPwd)) {
            $errors['confPwd'] = '*Required';
        }

        if (!ValidateModel::validatePassword($newPwd) && !isset($errors['newPwd'])) {
            $errors['newPwd'] = '*Invalid password format';
        }

        if ($newPwd != $confPwd && !isset($errors['confPwd'])) {
            $errors['confPwd'] = '*Password does not match';
        }

        if (!$this->verifyPwd($email, $curPwd) && !isset($errors['curPwd'])) {
            $errors['curPwd'] = '*Incorrect password';
        }

        return $errors;
    }

    /**
     * GET USER DETAILS
     */

    /** Get user details by user_id */
    public function getUserById($id)
    {
        $sql = <<<SQL
            SELECT * FROM user WHERE user_id = :id
        SQL;

        $params = [
            ':id' => $id
        ];

        $user = DatabaseModel::exec($sql, $params)->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

    /** Get current user ID */
    public static function getCurUserId()
    {
        $session = SessionModel::getSession();
        return isset($session['user_id']) ? $session['user_id'] : null;
    }

    /** Get user role by ID */
    public static function getRoleById($userId)
    {
        $sql = <<<SQL
            SELECT role FROM user WHERE user_id = :userId
        SQL;

        $params = [
            ':userId' => $userId
        ];

        return DatabaseModel::exec($sql, $params)->fetchColumn();
    }

    /** Get current user role */
    public static function getCurUserRole()
    {
        $session = SessionModel::getSession();
        return isset($session['role']) ? $session['role'] : 'guest';
    }

    /** Get current user email */
    public function getCurUserEmail()
    {
        $userId = UserModel::getCurUserId();

        $sql = <<<SQL
            SELECT email FROM user WHERE user_id = :userId
        SQL;

        $params = [
            ':userId' => $userId
        ];

        return DatabaseModel::exec($sql, $params)->fetchColumn();
    }
}
