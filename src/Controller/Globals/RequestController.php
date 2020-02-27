<?php

namespace App\Controller\Globals;

/**
 * Class RequestController
 * @package App\Controller
 */
class RequestController
{
    /**
     * @var mixed
     */
    private $request = null;

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->request = filter_var_array($_REQUEST);
    }

    /**
     * @return mixed
     */
    public function getRequestArray()
    {
        return $this->request;
    }

    /**
     * @param string $var
     * @return mixed
     */
    public function getRequestVar(string $var)
    {
        return $this->request[$var];
    }
}