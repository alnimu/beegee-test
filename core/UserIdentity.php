<?php


class UserIdentity
{
    private static $_users = [
        'admin' => '123'
    ];
    

    public function login($login, $password)
    {
        if (isset(self::$_users[$login]) and self::$_users[$login] == $password) {
            $_SESSION['username'] = $login;
            return true;
        }
        
        return false;
    }

    public function logout()
    {
        session_destroy();
    }
    
    public function isGuest()
    {
        return !isset($_SESSION['username']);
    }

    public function getName()
    {
        return isset($_SESSION['username']) ? $_SESSION['username'] : '';
    }
}