<?php 

/**
 * FoodBridge - A platform connecting food donors, volunteers, and nonprofits
 * to redistribute surplus food, reduce waste, and combat hunger.
 * 
 * @author
 * - github.com/dashlsl
 * - github.com/OwenTay66
 */

 define('ROOT', __DIR__);
 define('ROOT_URI', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/foodbridge');
 define('ACCESS', true);

 date_default_timezone_set('Asia/Kuala_Lumpur');

 require_once ROOT . '/app/config/debug.php';
 require_once ROOT . '/app/views/views.php';
 require_once ROOT . '/app/routes/routes.php';