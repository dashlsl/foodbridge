<?php

class Session
{
  private static $timeout_duration = 30 * 60; // 30 minutes

  // Initialize Session
  public static function init()
  {
    if (version_compare(phpversion(), '5.4.0', '<')) {
      if (session_id() == '') {
        session_start();
      }
    } else {
      if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }
    }

    // Check if session timeout based on login time
    self::sessionTimeout();
  }

  // Set Session
  public static function set($key, $val)
  {
    $_SESSION[$key] = $val;
  }

  // Get Session
  public static function get($key)
  {
    if (isset($_SESSION[$key])) {
      return $_SESSION[$key];
    } else {
      return false;
    }
  }

  // Timeout Session after 10 minutes

  // Destroy Session
  public static function destroy($isTimeout = false)
  {
    // If it's a timeout, set a flag
    if ($isTimeout) {
      self::set('timeout', TRUE);
    }

    session_destroy();
    session_unset();
    // Remove all session variables

    // Redirect based on the flag
    if ($isTimeout) {
      // Redirect to timeout page
      echo "<script>window.location='timeout.php';</script>";
    } else {
      // Redirect to login page
      echo "<script>window.location='login.php';</script>";
    }
  }

  // Session Timeout
  public static function sessionTimeout()
  {
    if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > self::$timeout_duration)) {
      self::destroy(true); // Pass true to set a flag for timeout
    }
  }  
}