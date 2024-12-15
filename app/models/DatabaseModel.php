<?php

namespace App\Models;

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

use PDO;
use PDOException;

class DatabaseModel
{
    /** Database connection */
    private static $connection = null;

    /** Database tables */
    private static $tables = [
        'users',
        'addresses',
        'food_donations',
        'food_delivery',
        'food_receivers',
        'donation_feedback',
        'posts',
        'votes',
        'notifications'
    ];

    /** Connect to database and return connection */
    public static function connect()
    {
        if (self::$connection === null) {
            require_once ROOT . '/app/config/config.php';

            try {
                self::$connection = new PDO(
                    'mysql:host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['database'],
                    $dbConfig['username'],
                    $dbConfig['password']
                );
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                return false;
            }
        }
        return self::$connection;
    }

    /** Install tables */
    public static function installTables()
    {
        require_once ROOT . '/app/config/database.php';

        self::$connection->prepare($sql)->execute();
    }

    /** Check if tables exist */
    public static function checkTables()
    {
        foreach (self::$tables as $table) {
            $sql = <<<SQL
                SHOW TABLES LIKE :table;
            SQL;

            $stmt = self::$connection->prepare($sql);
            $stmt->bindParam(':table', $table);
            $stmt->execute();
            $result = $stmt->fetchColumn();

            if (!$result) {
                return false;
            }
        }
        return true;
    }

    /** Validate if database and tables are setup */
    public static function validateDbSetup()
    {
        if (self::connect()) {
            if (!self::checkTables()) {
                self::installTables();
            }
            return true;
        }
        return false;
    }

    /** Execute SQL query
     * and convert array to PDO parameters
     */
    public static function exec($sql, $params = [])
    {
        $stmt = self::connect()->prepare($sql);

        if (count($params) > 0) {
            foreach ($params as $key => &$value) {
                // Check if value is integer or string
                if (is_integer($value)) {
                    $stmt->bindParam($key, $value, PDO::PARAM_INT);

                } else {
                    $stmt->bindParam($key, $value, PDO::PARAM_STR);
                }
            }
        }
        $stmt->execute();
        return $stmt;
    }

    // SAMPLES

    /** Input samples for testing */
    private static $sampleUsers = [
        'johndoe@email.com',
        'janesmith@email.com'
    ];
    private static $sampleDonations = [
        ['donor_email' => 'johndoe@email.com', 'food_description' => 'rice', 'quantity' => 100, 'pickup_time' => '2024-12-15 10:00:00'],
        ['donor_email' => 'johndoe@email.com', 'food_description' => 'beans', 'quantity' => 50, 'pickup_time' => '2024-12-15 12:00:00'],
        ['donor_email' => 'janesmith@email.com', 'food_description' => 'bread', 'quantity' => 200, 'pickup_time' => '2024-12-16 14:00:00']
    ];
    private static $sampleAddresses = [
        ['user_email' => 'johndoe@email.com', 'address_type' => 'pickup', 'address' => '123 Main St', 'city' => 'Springfield', 'state' => 'IL', 'zipcode' => '62701'],
        ['user_email' => 'janesmith@email.com', 'address_type' => 'delivery', 'address' => '456 Oak St', 'city' => 'Springfield', 'state' => 'IL', 'zipcode' => '62702']
    ];

    /** Check if sample users exist */
    private static function checkSampleUsers()
    {
        $sql = "SELECT `email` FROM `users` WHERE `email` = :email";

        foreach (self::$sampleUsers as $user) {
            $stmt = self::exec($sql, [':email' => $user['email']]);
            $result = $stmt->fetchColumn();

            if (!$result) {
                return false;
            }
        }
        return true;
    }

    /** Check if sample donations exist */
    private static function checkSampleDonations()
    {
        $sql = "SELECT `food_description` FROM `food_donations` WHERE `food_description` = :food_description";

        foreach (self::$sampleDonations as $donation) {
            $stmt = self::exec($sql, [':food_description' => $donation['food_description']]);
            $result = $stmt->fetchColumn();

            if (!$result) {
                return false;
            }
        }
        return true;
    }

    /** Check if sample addresses exist */
    private static function checkSampleAddresses()
    {
        $sql = "SELECT `address` FROM `addresses` WHERE `address` = :address AND `user_id` = (SELECT `user_id` FROM `users` WHERE `email` = :email)";

        foreach (self::$sampleAddresses as $address) {
            $stmt = self::exec($sql, [':address' => $address['address'], ':email' => $address['user_email']]);
            $result = $stmt->fetchColumn();

            if (!$result) {
                return false;
            }
        }
        return true;
    }

    /** Install samples */
    private static function installSamples()
    {
        require_once ROOT . '/app/config/sample.php';

        self::$connection->prepare($sql)->execute();
    }

    /** Validate if sample users and products are setup
     * If not, setup sample users and products
     */
    public static function validateSampleSetup()
    {
        if (!self::checkSampleUsers() || !self::checkSampleDonations() || !self::checkSampleAddresses()) {
            self::installSamples();
            return false;
        }
        return true;
    }
}