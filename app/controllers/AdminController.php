<?php

namespace App\Controllers;

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

use App\Helpers\AjaxHelper;
use App\Views\ViewManager;
use App\Models\DonationModel;
use App\Models\AdminModel;

class AdminController
{
    /**
     * Managing Users
     */
    public function adminUserListView()
    {
        return ViewManager::renderView('admin_user_list_view', [], ['admin_nav']);
    }

    public function getUserList()
    {
        $am = new AdminModel;
        $result = $am->getAllUsers();

        AjaxHelper::sendResponse(true, $result);
    }

    public function editUser()
    {
        $userId = $_GET['user-id'];
        $role = $_POST['user-role'];

        $am = new AdminModel;
        $result = $am->editUserRole($userId, $role);  // Assume method to update user's role

        AjaxHelper::sendResponse($result);
    }

    public function deleteUser()
    {
        $userId = $_GET['user-id'];

        $am = new AdminModel;
        $result = $am->deleteUser($userId);

        AjaxHelper::sendResponse($result);
    }

    /**
     * Managing Donations
     */

    // View for the latest donations
    public function adminDonationListView()
    {
        return ViewManager::renderView('admin_donation_view', [], ['admin_nav']);
    }

    // Get the latest donations
    public function getDonations()
    {
        $dm = new DonationModel;
        $result = $dm->getAllDonations();

        AjaxHelper::sendResponse(true, $result);
    }

    public function updateDonation()
    {
        $donationId = $_GET['donation-id'];
        $status = $_POST['donation-status'];

        $dm = new DonationModel;
        $result = $dm->updateDonation($donationId, $status);

        AjaxHelper::sendResponse($result);
    }

    public function deleteDonation()
    {
        $donationId = $_GET['donation-id'];

        $dm = new DonationModel;
        $result = $dm->deleteDonation($donationId);

        AjaxHelper::sendResponse($result);
    }
}