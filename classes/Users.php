<?php


class Users
{
  private $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function checkExistEmail($email)
  {
    $sql = "SELECT email from users WHERE email = :email";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute([
      ':email' => $email
    ]);
    if ($stmt->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function registerUser($data)
  {
    // Extract data and check for htmlSpecialChars
    $email = htmlspecialchars(trim($data['email']));
    $role = isset($data['role']) ? htmlspecialchars(trim($data['role'])) : '';
    $password = $data['password'];
    $phone = htmlspecialchars(trim($data['phone']));
    $address = htmlspecialchars(trim($data['address']));

    // Check if any required fields are empty
    if (empty($email) || empty($password) || empty($phone) || empty($address)) {
      return 'All fields are required.';
    }
    // Validate email format
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return 'Invalid email format.';
    }
    // Check if email already exists in the database
    elseif ($this->checkExistEmail($email)) {
      return 'Email already exists.';
    }
    // Validate password strength: Minimum 8 characters, at least 1 uppercase letter, and 1 number
    elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&]{8,}$/', $password)) {
      return 'Password must be at least 8 characters long and include at least one uppercase letter and one number.';
    }
    // Validate phone number format: Must be 10 digits or 11 digits if starting with '011'
    elseif (!preg_match('/^(\(\d{2,}\) ((\d{4}-\d{4})|(9\d{4}-\d{4})))|(\d{2})((9\d{8})|(\d{8}))$/', $phone)) {
      return 'Phone number must contain 10 to 11 digits.';
    }
    // Validate role: Must be one of 'donor', 'volunteer', or 'receiver'
    elseif (!in_array($role, ['donor', 'volunteer', 'receiver'])) {
      return 'Please select a role.';
    } else {

      // Hash the password for security
      $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

      // Insert the user data into the database
      $sql = "INSERT INTO users (email, password, role, phone, address)
      VALUES (:email, :password, :role, :phone, :address)";
      $stmt = $this->db->pdo->prepare($sql);
      $result = $stmt->execute([
        ':email' => $email,
        ':password' => $hashedPassword,
        ':role' => $role,
        ':phone' => $phone,
        ':address' => $address
      ]);

      return $result ? 'Registered successfully. Redirecting to login page...' : 'Failed to register.';
    }
  }

  // Check if email and password match in the database
  public function loginDBcheck($email, $password)
  {
    // Get the email and do password_verify to check if the password matches
    $sql = "SELECT *
            FROM users
            WHERE email = :email";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute([
      ':email' => $email
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
      if (password_verify($password, $result['password'])) {
        return $result;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  // Check user account status
  public function checkUserStatus($email)
  {
    $sql = "SELECT status
            FROM users
            WHERE email = :email";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute([
      ':email' => $email
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['status'] == 'active') {
      return true;
    } else {
      return false;
    }
  }

  // User login
  public function loginUser($data)
  {
    // Extract data and check for htmlSpecialChars
    $email = htmlspecialchars(trim($data['email']));
    $password = htmlspecialchars(trim($data['password']));

    // Check if any required fields are empty
    if (empty($email) || empty($password)) {
      return 'All fields are required.';
    }
    // Validate email format
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return 'Invalid email format.';
    } else {
      $active = $this->checkUserStatus($email);
      $user = $this->loginDBcheck($email, $password);

      if (!$active) {
        return 'Account is suspended or deleted.';
      } elseif ($user) {
        Session::init();
        Session::set('login', TRUE);
        Session::set('id', $user['id']);
        Session::set('email', $user['email']);
        Session::set('role', $user['role']);
        Session::set('logMsg', 'Login successful. Redirecting...');

        // Store the login time for session timeout
        Session::set('login_time', time());

        Session::set('isAdmin', $user['isAdmin']);
        Session::set('points', $user['points']);
        header("Location: index.php");
      } else {
        return 'Incorrect email or password.';
      }
    }
  }

  // Get user by id
  public function getUserById($id)
  {
    $sql = "SELECT *
            FROM users
            WHERE id = :id LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute([
      ':id' => $id
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
      return $result;
    } else {
      return false;
    }
  }

  // Update user by id
  public function updateUser($id, $data)
  {
    // Extract data and check for htmlSpecialChars
    $email = htmlspecialchars(trim($data['email']));
    $role = htmlspecialchars(trim($data['role']));
    $phone = htmlspecialchars(trim($data['phone']));
    $address = htmlspecialchars(trim($data['address']));

    // Check if any required fields are empty
    if (empty($email) || empty($role) || empty($phone) || empty($address)) {
      return 'All fields are required.';
    }
    // Validate email format
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return 'Invalid email format.';
    }
    // Validate phone number format: Must be 10 digits or 11 digits if starting with '011'
    elseif (!preg_match('/^01([0-9&&[^1]]\d{7}|1\d{8})$/', $phone)) {
      return 'Phone number must contain 10 to 11 digits.';
    }
    // Validate role: Must be one of 'donor', 'volunteer', or 'receiver'
    elseif (!in_array($role, ['donor', 'volunteer', 'receiver'])) {
      return 'Invalid role selected.';
    } else {

      // Update the user data in the database
      $sql = "UPDATE users
              SET email = :email, role = :role, phone = :phone, address = :address
              WHERE id = :id";
      $stmt = $this->db->pdo->prepare($sql);
      $result = $stmt->execute([
        ':email' => $email,
        ':role' => $role,
        ':phone' => $phone,
        ':address' => $address,
        ':id' => $id
      ]);

      return $result ? 'User updated successfully.' : 'Failed to update user.';
    }
  }

  // Delete user by id
  public function deleteUser($id)
  {
    $sql = "DELETE FROM users
            WHERE id = :id";
    $stmt = $this->db->pdo->prepare($sql);
    $result = $stmt->execute([
      ':id' => $id
    ]);

    return $result ? 'User delete successfully.' : 'Failed to delete user.';
  }

  // Check current password by id
  public function checkPwd($id, $data)
  {
    $password = htmlspecialchars(trim($data['password']));
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "SELECT password
            FROM users
            WHERE password = :password AND id = :id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute([
      ':password' => $hashedPassword,
      ':id' => $id
    ]);

    if ($stmt->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  // Update password by id
  public function updatePwd($id, $data)
  {
    $old_password = htmlspecialchars(trim($data['old_password']));
    $new_password = htmlspecialchars(trim($data['new_password']));

    if (empty($old_password) || empty($new_password)) {
      return 'All fields are required.';
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/', $new_password)) {
      return 'Password must be at least 8 characters long and include at least one uppercase letter and one number.';
    } else {
      $old_password = $this->checkPwd($id, $old_password);

      if ($old_password == FALSE) {
        return 'Incorrect password.';
      } else {
        $hashedPassword = password_hash($new_password, PASSWORD_BCRYPT);

        $sql = "UPDATE users
                SET password = :password
                WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $result = $stmt->execute([
          ':password' => $hashedPassword,
          ':id' => $id
        ]);

        return $result ? 'Password updated successfully.' : 'Failed to update password.';
      }
    }
  }
}