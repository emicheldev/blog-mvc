<?php

namespace App\Controller\Globals;

/**
 * Class CookieController
 * @package App\Controller
 */
class CookieController
{
    /**
     * @var mixed
     */
    private $cookie = null;

    /**
     * @var
     */
    private $alert = null;

    /**
     * CookieController constructor.
     */
    public function __construct()
    {
        $this->cookie = filter_input_array(INPUT_COOKIE);

        if (isset($this->cookie['alert'])) {
            $this->alert  = $this->cookie['alert'];
        }
    }

    /**
     * @param string $name
     * @param string $value
     * @param int $expire
     * @return mixed|void
     */
    public function createCookie(string $name, string $value = '', int $expire = 0)
    {
        if ($expire === 0) {
            $expire = time() + 3600;
        }
        setcookie($name, $value, $expire, '/');
    }


    public function destroyCookie(string $name)
    {
        if ($this->cookie[$name] !== null) {

            $this->createCookie($name, '', time() - 3600);
        }
    }

    /**
     * @return mixed
     */
    public function getCookieArray()
    {
        return $this->cookie;
    }

    /**
     * @param string $var
     * @return mixed
     */
    public function getCookieVar(string $var)
    {
        return $this->cookie[$var];
    }

    /**
     * @param string $message
     */
    public function createAlert(string $message)
    {
        $this->createCookie('alert', $message);
    }

    /**
     * @return bool
     */
    public function hasAlert()
    {
        return empty($this->alert) == false;
    }

    /**
     * @return mixed|void
     */
    public function readAlert()
    {
        if (isset($this->alert)) {
            echo filter_var($this->alert, FILTER_SANITIZE_SPECIAL_CHARS);

            $this->destroyCookie('alert');
        }
    }
}