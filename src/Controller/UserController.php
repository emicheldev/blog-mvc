<?php

namespace App\Controller;

use App\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class UserController
 * Manages the Userpage
 * @package App\Controller
 */
class UserController extends Controller 
{
    /**
     * Renders the View User
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        return $this->twig->render('/registration/register.twig');
    }

    public function loginMethod()
    {
        return $this->twig->render('/registration/login.twig');
    }

        /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function registerMethod()
    {
        if (!empty($this->post->getPostArray())) {
            $user = ModelFactory::getModel('User')->readData($this->post->getPostVar('email'), 'email');

            if (empty($user) == false) {
                $this->session->set('user','Il existe déjà un compte utilisateur avec cette adresse e-mail');
            }

            $data['password']   = password_hash($this->post->getPostVar('password'), PASSWORD_DEFAULT);
            $data['login']   = $this->post->getPostVar('login');
            $data['email']  = $this->post->getPostVar('email');

            ModelFactory::getModel('User')->createData($data);
            $this->session->set('user','Nouvel utilisateur créé avec succès !');
            

            $this->redirect('home');
        }
        return $this->render('/registration/register.twig');
    }
}