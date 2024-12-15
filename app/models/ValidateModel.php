<?php

namespace App\Models;

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

class ValidateModel
{
    // Define regex patterns as constants
    private const EMAIL_REGEX = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    /**
     * Validate password strength.
     * - At least 8 characters long
     * - At least 1 alphabet character
     * - At least 1 numeric character
     * - At least 1 special character
     */
    private const PASSWORD_REGEX = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*\W)[A-Za-z\d\W]{8,}$/';
    private const PHONE_REGEX = '/^01([0-9&&[^1]]\d{7}|1\d{8})$/';

    /** Validate email */
    public static function validateEmail(string $email): bool
    {
        // Sanitize email before validation
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        return preg_match(self::EMAIL_REGEX, $email) === 1;
    }

    /** Validate password */
    public static function validatePassword(string $password): bool
    {
        return preg_match(self::PASSWORD_REGEX, $password) === 1;
    }

    /** Validate phone number */
    public static function validatePhone(string $phone): bool
    {
        return preg_match(self::PHONE_REGEX, $phone) === 1;
    }

    /** Validate login */
    public static function validateLogin(): bool
    {
        return isset($_SESSION['foodbridge_user']);
    }
}
