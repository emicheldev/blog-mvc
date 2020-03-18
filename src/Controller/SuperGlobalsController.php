<?php

namespace App\Controller;

use App\Controller\Globals\CookieController;
use App\Controller\Globals\SessionController;

/**
 * Class SuperGlobalsController
 * @package App\Controller
 */
abstract class SuperGlobalsController
{
    /**
     * @var CookieController
     */
    protected $cookie = null;

    /**
     * @var FlashController
     */
    protected $flash = null;

    /**
     * @var SessionController
     */
    protected $session = null;

    /**
     * SuperGlobalsController constructor
     */
    public function __construct()
    {
        $this->get      = filter_input_array(INPUT_GET);
        $this->post     = filter_input_array(INPUT_POST); 
        $this->cookie   = new CookieController();
        $this->session  = new SessionController();
    }
}