<?php

namespace App\Models;

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

use PDO;
use App\Models\DatabaseModel;

class AdminModel
{
    /** Get all users */
    public function getAllUsers()
    {
        $sql = <<<SQL
            SELECT
                *
            FROM
                users
        SQL;

        return DatabaseModel::exec($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Edit user role */
    public function editUserRole($userId, $role)
    {
        $sql = <<<SQL
            UPDATE
                user
            SET
                role = :role
            WHERE
                user_id = :userId
        SQL;

        $params = [
            ':role' => $role,
            ':userId' => $userId
        ];

        DatabaseModel::exec($sql, $params);
        return true;
    }

    /** Delete user */
    public function deleteUser($userId)
    {
        $sql = <<<SQL
            DELETE FROM
                user
            WHERE
                user_id = :userId
        SQL;

        $params = [
            ':userId' => $userId
        ];

        DatabaseModel::exec($sql, $params);
        return true;
    }
}
