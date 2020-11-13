<?php

namespace App;

class Auth
{

    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Auth();
        }
        return self::$instance;
    }

    public function isAdmin()
    {
        $data = Storage::fileToArray('admin');
        return $_SESSION['admin'] == $data['session'] && $data['session'] != '';
    }

    public function checkAdmin()
    {
        if (!$this->isAdmin()) {
            Helper::redirect('/login');
        }
    }

    private function setSession($verify)
    {
        $_SESSION['admin'] = $verify;
        Storage::saveArrayParam('admin', 'session', $verify);
    }

    public function adminOnline()
    {
        $token = sha1(time());
        $this->setSession($token);
    }

    public function adminOffline()
    {
        $this->setSession("");
    }

    public function verify($name, $password)
    {
        $data = Storage::fileToArray('admin');
        if (sha1($name . $password . $name) == $data['verify']) {
            return true;
        }
        return false;
    }

}