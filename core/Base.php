<?php

defined('BASE_PATH') or define('BASE_PATH', dirname(__FILE__) . '/..');

class Base
{
    public static function autoload($className)
    {
        if (isset(self::$_coreClasses[$className]))
            include(BASE_PATH . self::$_coreClasses[$className]);

        $classFile = BASE_PATH . '/application/controllers/' . $className . '.php';
        if(is_file($classFile)) {
            include($classFile);
            return true;
        }

        $classFile = BASE_PATH . '/application/models/' . $className . '.php';
        if(is_file($classFile)) {
            include($classFile);
            return true;
        }

        return class_exists($className);
    }

    private static $_coreClasses = [
        'Application' => '/core/Application.php',
        'ApplicationException' => '/core/ApplicationException.php',
        'BaseController' => '/core/BaseController.php',
        'BaseView' => '/core/BaseView.php',
        'BaseModel' => '/core/BaseModel.php',
        'UserIdentity' => '/core/UserIdentity.php',
    ];
}

spl_autoload_register(['Base', 'autoload']);