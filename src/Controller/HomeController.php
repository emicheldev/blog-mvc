<?php

namespace App\Controller;

use App\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class HomeController
 * Manages the Homepage
 * @package App\Controller
 */
class HomeController extends Controller 
{
    /**
     * Renders the View Home
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function home()
    {
        $allUsers = ModelFactory::getModel('User')->listData();

        return $this->viewPage($this->twig->render('/pages/home.twig', ['allUsers' => $allUsers]));
    }
}