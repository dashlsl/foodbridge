<?php

namespace App\Models;

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

use PDO;
use DateTime;
use App\Models\DatabaseModel;

class DonationModel
{
    /** Add a new donation */
    public function addDonation($donorId, $description, $quantity, $address, $puDateTime)
    {
        $errors = $this->validateAddDonation(
            $description,
            $quantity,
            $address,
            $puDateTime
        );
        if (count($errors) > 0) {
            return $errors;
        }

        // Default status
        $status = 'pending';

        // Insert the donation into the database
        $sql = <<<SQL
        INSERT INTO
            food_donations (donor_id, food_description, quantity, address_id, pickup_time, status)
        VALUES
            (:donor_id, :food_description, :quantity, :address_id, :pickup_time, :status)
        SQL;

        $params = [
            ':donor_id' => $donorId,
            ':food_description' => $description,
            ':quantity' => $quantity,
            ':address' => $address,
            ':pickup_time' => $puDateTime,
            ':status' => $status
        ];

        DatabaseModel::exec($sql, $params);

        return true;
    }

    /** Validate donation form */
    private function validateAddDonation($description, $quantity, $address, $puDateTime)
    {
        $errors = [];

        if (empty($description)) {
            $errors['description'] = '*Required';
        }

        if (empty($quantity)) {
            $errors['foodQty'] = '*Required';
        }

        if (empty($address)) {
            $errors['donationAddress'] = '*Required';
        }

        if (empty($puDateTime)) {
            $errors['puDateTime'] = '*Required';
        }

        if (!is_numeric($quantity) && !isset($errors['foodQty'])) {
            $errors['foodQty'] = '*Must be a number';
        }

        $curDateTime = new DateTime();
        $curDateTime = $curDateTime->format('Y-m-d H:i:s');

        if ($puDateTime < $curDateTime && !isset($errors['puDateTime'])) {
            $errors['puDateTime'] = '*Must be a future date and time';
        }

        return $errors;
    }

    /** Get donation by user id */
    public function getDonationsByUserID($donorId)
    {
        $sql = <<<SQL
            SELECT
                *
            FROM
                food_donations
            WHERE
                donor_id = :donor_id
            ORDER BY
                created_at DESC
        SQL;

        $params = [
            'donor_id' => $donorId
        ];

        return DatabaseModel::exec($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Get all donations */
    public function getAllDonations(): array
    {
        $sql = <<<SQL
            SELECT
                *
            FROM
                food_donations
            ORDER BY
                created_at DESC
        SQL;

        return DatabaseModel::exec($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Get all donors */
    public function getAllDonors()
    {
        $sql = <<<SQL
            SELECT
                *
            FROM
                users
            WHERE
                role = 'donor'
        SQL;

        return DatabaseModel::exec($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Update donation */
    public function updateDonation($donationId, $status)
    {
        $sql = <<<SQL
            UPDATE
                food_donations
            SET
                status = :status
            WHERE
                donation_id = :donationId
        SQL;

        $params = [
            ':status' => $status,
            ':donation_id' => $donationId
        ];

        DatabaseModel::exec($sql, $params);

        return true;
    }

    /** Delete donation */
    public function deleteDonation($donationId)
    {
        $sql = <<<SQL
            DELETE FROM
                food_donations
            WHERE
                donation_id = :donationId
        SQL;

        $params = [
            ':donation_id' => $donationId
        ];

        DatabaseModel::exec($sql, $params);

        return true;
    }
}