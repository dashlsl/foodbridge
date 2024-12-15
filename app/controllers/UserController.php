<?php

namespace App\Controllers;

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

use App\Models\UserModel;
use App\Models\DonationModel;
use App\Models\VolunteerModel;
use App\Views\ViewManager;
use App\Helpers\AjaxHelper;
use App\Models\ValidateModel;
use DateTime;

class UserController
{
    /**
     * ACCOUNT MANAGEMENT
     */

    // Registration
    public function registerView()
    {
        return ViewManager::renderView('registerview');
    }

    public function register()
    {
        $role = $_POST['role'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $pwd = $_POST['password'];
        $phone = $_POST['phone'] ?? null;

        $um = new UserModel;
        $result = $um->register($role, $name, $email, $pwd, $phone);
        $flag = !is_array($result);

        AjaxHelper::sendResponse($flag, $result);
    }

    // Login
    public function loginView()
    {
        return ViewManager::renderView('login_view');
    }

    public function login()
    {
        $email = $_POST['email'];
        $pwd = $_POST['password'];

        $um = new UserModel;
        $result = $um->login($email, $pwd);
        $flag = !is_array($result);

        AjaxHelper::sendResponse($flag, $result);
    }

    public function logout()
    {
        $um = new UserModel();
        $um->logout();

        header('Location: /foodbridge/login');
        die();
    }

    public function editProfileView()
    {
        if (!ValidateModel::validateLogin()) {
            header('Location: /foodbridge/login');
            die();
        }

        $userId = UserModel::getCurUserId();

        $um = new UserModel;
        $user = $um->getUserById($userId);

        $params['user'] = $user;

        return ViewManager::renderView(
            'editprofileview', 
            $params);
    }

    public function updateProfile()
    {
        $userId = UserModel::getCurUserId();
        $userName = $_POST['user-name'];

        $um = new UserModel();
        $result = $um->updateProfile($userId, $userName);
        $flag = !is_array($result);

        AjaxHelper::sendResponse($flag, $result);
    }

    public function updatePassword()
    {
        $userId = UserModel::getCurUserId();
        $currentPwd = $_POST['cur-pwd'];
        $newPwd = $_POST['new-pwd'];
        $confirmPwd = $_POST['confirm-pwd'];

        $um = new UserModel();
        $result = $um->updatePwd($userId, $currentPwd, $newPwd, $confirmPwd);
        $flag = !is_array($result);

        AjaxHelper::sendResponse($flag, $result);
    }

    // public function deleteAccount()
    // {
    //     $userId = UserModel::getCurUserId();
    //     $pwd = $_POST['password'];

    //     $um = new UserModel();
    //     $result = $um->deleteAccount($userId, $pwd);
    //     $flag = !is_array($result);

    //     AjaxHelper::sendResponse($flag, $result);
    // }

    /**
     * DONORS
     */

    /** Donation Form - Donors */
    public function donateFormView()
    {
        $dm = new DonationModel();

        // Current date and time
        $curDateTime = new DateTime();
        $params['curDate'] = $curDateTime->format('Y-m-d');
        $params['curTime'] = $curDateTime->format('H:i');

        return ViewManager::renderView('donate_form_view', $params);
    }

    public function donate()
    {
        $donorId = UserModel::getCurUserId();

        $dnfoodDesc = $_POST['food-desc'];
        $dnQuantity = $_POST['quantity'];
        $dnPickupAddress = $_POST['pickup-address'];
        $dnDate = $_POST['pickup-date'];
        $dnTime = $_POST['pickup-time'];

        $dateTime = new DateTime($dnDate . ' ' . $dnTime);
        $dnDateTime = $dateTime->format('Y-m-d H:i:s');

        $dm = new DonationModel();
        $result = $dm->addDonation(
            $donorId,
            $dnfoodDesc,
            $dnQuantity,
            $dnPickupAddress,
            $dnDateTime
        );
        $flag = !is_array($result);

        AjaxHelper::sendResponse($flag, $result);
    }

    /** Donors view their donation history */
    public function donationsView()
    {
        $userId = UserModel::getCurUserId();

        $dm = new DonationModel();
        $donations = $dm->getDonationsByUserId($userId);

        $params['donations'] = $donations;

        return ViewManager::renderView('donations_view', $params);
    }

    /**
     * VOLUNTEERS
     */

    /** Volunteer Form - Volunteers */
    public function volunteerFormView()
    {
        return ViewManager::renderView('volunteer_form_view');
    }
}