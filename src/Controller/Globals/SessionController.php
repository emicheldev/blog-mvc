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

    public function remove($name)
    {
        unset($_SESSION[$name]);
    }

    public function stop()
    {
        session_destroy();
    }

    /**
     * isLogged
     *
     * @return void
     */
    public function isLogged()
    {
        if (array_key_exists('user', $this->session)) {

            if (!empty($this->session["user"])) {

                return true;
            }
        }
        return false;
    }

    /**
     * @return array|mixed
     */
    public function getSessionArray()
    {
        return $this->session;
    }

    /**
     * @return mixed
     */
    public function getUserArray()
    {
        if ($this->isLogged() === false) {
            $this->user = [];
        }

        return $this->user;
    }

    /**
     * @param $var
     * @return mixed
     */
    public function getUserVar($var)
    {
        if ($this->isLogged() === false) {
            $this->user[$var] = null;
        }

        return $this->user[$var];
    }

        /**
     * @param int $id
     * @param string $login
     * @param string $email
     * @param string $role
     */
    public function createSession(int $id, string $login, string $email, string $role)
    {
        $_SESSION['user'] = [
            'id'     => $id,
            'login'  => $login,
            'email'  => $email,
            'role'   => $role,
        ];
    }


}