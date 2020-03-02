<?php

namespace App\Controller;

use App\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class AuthController
 * Manages the Authpage
 * @package App\Controller
 */
class AuthController extends Controller 
{
    /**
     * Renders the View Auth
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        return $this->render('auth/login.twig');
    }

    public function loginMethod()
    {
      

        if (!empty($this->post)) {
            

            $user = ModelFactory::getModel('User')->readData($this->post['login'], 'login');

            if (password_verify($this->post['password'], $user['password'])) {

                $this->session->createSession(
                    $user['id'],
                    $user['login'],
                    $user['email']
                );

                $this->cookie->createAlert('Authentification réussie, bienvenue ' . $user['login'] .' !');
               
                $this->redirect('admin');
            }

            $this->cookie->createAlert('Authentification échouée !');
        }
        return $this->render('auth/login.twig');
    }
}