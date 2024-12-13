<?php

namespace App\Models;

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

class SessionModel
{
    /** Start session if not started */
    private static function startSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /** Set session variables after successful login */
    public static function setSession($userId, $role)
    {
        self::startSession();
        $_SESSION['user_id'] = $userId;
        $_SESSION['role'] = $role;
        $_SESSION['last_activity'] = time();
    }

    /** Get session variable */
    public static function getSession($key = null)
    {
        self::startSession(); // Ensure session is started
    
        // If a specific key is provided, return that session value, or null if not set
        if ($key !== null && isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    
        // If no key is provided, return the whole session array (or specific data)
        return $_SESSION;
    }    

    /** Handle logout */
    public static function handleLogout($redirectUrl = '/app/views/login.php')
    {
        self::startSession();

        if (isset($_GET['logout']) && $_GET['logout'] == true) {
            self::destroySession();
            header("Location: $redirectUrl");
            exit();
        }
    }

    /** Handle expired session */
    public static function handleSessionTimeout($timeout = 300, $redirectUrl = '/app/views/session_expired.php')
    {
        self::startSession();

        if (isset($_SESSION['user_id']) && isset($_SESSION['last_activity'])) {
            $inactiveTime = time() - $_SESSION['last_activity'];
            if ($inactiveTime > $timeout) {
                self::destroySession();
                header("Location: $redirectUrl");
                exit();
            }
        }

        self::updateLastActivity();
    }

    /** Update the last activity timestamp for the current session */
    public static function updateLastActivity()
    {
        self::startSession();
        $_SESSION['last_activity'] = time();
    }

    /** Destroy all session data */
    public static function destroySession()
    {
        self::startSession();
        $_SESSION = [];
        session_destroy();
    }
}