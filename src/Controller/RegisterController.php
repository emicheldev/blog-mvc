<?php

namespace App\Controller;

use App\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class RegisterController
 * Manages the Registerpage
 * @package App\Controller
 */
class RegisterController extends Controller 
{
    /**
     * Renders the View Register
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function create()
    {
        return $this->viewPage($this->twig->render('/registration/create.twig'));
    }

    public function login()
    {
        return $this->twig->render('/registration/login.twig');
    }
}