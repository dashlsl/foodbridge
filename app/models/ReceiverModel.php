<?php

namespace App\Models;

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

use PDO;
use App\Models\DatabaseModel;

class ReceiverModel
{
    /** Get receiver's food deliveries */
    public function getDelByReceiverId($receiverId)
    {
        $sql = <<<SQL
            SELECT
                fd.donation_id, fd.food_description, fd.quantity, fd.pickup_time, fd.status AS donation_status,
                fdc.delivery_time, fdc.delivery_status, u.name AS volunteer_name, u.phone AS volunteer_phone
            FROM
                food_donations fd
            JOIN
                food_delivery fdc ON fd.donation_id = fdc.donation_id
            JOIN
                users u ON fdc.volunteer_id = u.user_id
            WHERE
                fdc.receiver_id = :receiver_id
            ORDER BY
                fdc.delivery_time DESC
        SQL;

        $params = [
            ':receiver_id' => $receiverId
        ];

        return DatabaseModel::exec($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Get receiver details by user ID */
    public function getReceiverByUserId($userId)
    {
        $sql = <<<SQL
            SELECT
                receiver_id, organization_name
            FROM
                food_receivers
            WHERE
                user_id = :user_id
        SQL;

        $params = [
            ':user_id' => $userId
        ];

        return DatabaseModel::exec($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }
}