<?php

namespace App\Controller\Globals;

/**
 * Class SessionController
 * @package App\Controller
 */
class SessionController
{
    private $session;

    public function __construct()
    {
        $this->session = filter_var_array($_SESSION);
    }

    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function get($name)
    {
            return $_SESSION[$name]["id"];
    }

    public function show($name,$value)
    {
        if(isset($_SESSION[$name]))
        {
            $key = $this->get($name);
            $this->remove($name);
            return $key;
        }
    }

    public function remove($name)
    {
        unset($_SESSION[$name]);
    }

    public function stop()
    {
        session_destroy();
    }
}