<?php

namespace App\Views;

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

use App\Models\UserModel;
use App\Models\ValidateModel;

class ViewManager
{
    private static $root = ROOT_URI;
    private static $viewRawInfo = [];
    private static $sampleRawInfo = [];
    private static $navRawInfo = [];

    /** Add view */
    public function addView(
        $viewName, 
        $viewTitle, 
        $viewCss = [], // Optional
        $viewJs = [], // Optional
        $permission = [], // Optional: for permission checking
        $login = false // Optional: for login checking
        ) 
    {
        if (array_key_exists($viewName, self::$viewRawInfo)) {
            throw new \Exception('View already exists');
        }
        self::$viewRawInfo[$viewName] = [
            'title' => $viewTitle,
            'css' => $viewCss,
            'js' => $viewJs,
            'permission' => $permission,
            'login' => $login
        ];
    }

    /** Render view based on view name */
    public static function renderView(
        $viewName, 
        $params = [], 
        $navName = []
        )
    {
        self::loginCheck($viewName);
        self::permissionCheck($viewName);

        if (!array_key_exists($viewName, self::$viewRawInfo)) {
            throw new \Exception('View not found');
        }
        $viewRawInfo = self::$viewRawInfo[$viewName];

        $viewInfo = [
            'title' => $viewRawInfo['title'] . ' | ReNew',
            'body' => self::returnViewBody($viewName, $params),
            'css' => $viewRawInfo['css'] ?? [],
            'js' => $viewRawInfo['js'] ?? []
        ];

        /**
         * Render navigation bar.
         */
        $viewInfo['nav']['top'] = '';
        $viewInfo['nav']['bottom'] = '';

        $navIndex = 0;
        while (count($navName) > $navIndex) {
            $curNavName = $navName[$navIndex];

            if (array_key_exists($curNavName, self::$navRawInfo)) {
                $navBody = self::returnNavBody($curNavName, $params);
                $viewInfo['nav']['top'] .= $navBody['top'];
                $viewInfo['nav']['bottom'] .= $navBody['bottom'];
                
                $viewInfo['css'] = array_merge($viewInfo['css'], self::$navRawInfo[$curNavName]['css']);
                $viewInfo['js'] = array_merge($viewInfo['js'], self::$navRawInfo[$curNavName]['js']);
            }
            $navIndex++;
        }

        require_once ROOT . '/app/views/mainview.php';
    }

    /** Login checking */
    private static function loginCheck($viewName)
    {
        if ((self::$viewRawInfo[$viewName]['login']) == true) {

            if (!ValidateModel::validateLogin()) {
                header('Location: /foodbridge/login');
                die();
            }
        }
    }

    /** Permission checking */
    private static function permissionCheck($viewName)
    {
        if (!empty(self::$viewRawInfo[$viewName]['permission'])) {
            $permArr = self::$viewRawInfo[$viewName]['permission'];

            $curRole = UserModel::getCurUserRole();

            if (!in_array($curRole, $permArr)) {
                header('Location: /foodbridge/');
                die();
            }
        }
    }

    /** Add navigation bar */
    public function addNav(
        $navName,
        $navCss = [], // Optional
        $navJs = [] // Optional
        )
    {
        if (array_key_exists($navName, self::$navRawInfo)) {
            throw new \Exception('Navbar already exists');
        }
        self::$navRawInfo[$navName] = [
            'css' => $navCss,
            'js' => $navJs
        ];
    }

    /** Return navigation bar body */
    private static function returnNavBody(
        $navName,
        )
    {
        require_once ROOT . '/app/views/navlist/' . $navName . '.php';
        return $nav;
    }

    /** Return view body */
    private static function returnViewBody(
        $viewName,
        )
    {
        require_once ROOT . '/app/views/viewlist/' . $viewName . '.php';
        return $body;
    }

}
