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
    /**
     * indexMethod
     *
     * @return void
     */
    public function indexMethod()
    {
    
        if ($this->session->islogged()) {
            $allUsers = ModelFactory::getModel('User')->listData();

            return $this->render('admin/user/index.twig', ['allUsers' => $allUsers]);
            $this->cookie->createAlert('Vous devez être connecté pour accéder à l\'administration');
        }
        $this->redirect('user!login');

     
    }

    public function logoutMethod()
    {
        $this->session->stop();

        $this->redirect('home');
    }

        /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function registerMethod()
    {
        if (!empty($this->post)) {
            $user = ModelFactory::getModel('User')->readData($this->post['email'], 'email');

            if (empty($user) == false) {
                $this->cookie->createAlert('Il existe déjà un compte utilisateur avec cette adresse e-mail');
            }

            $data['password']   = password_hash($this->post['password'], PASSWORD_DEFAULT);
            $data['login']   = $this->post['login'];
            $data['first_name']   = $this->post['login'];
            $data['email']  = $this->post['email'];

            ModelFactory::getModel('User')->createData($data);
            $this->cookie->createAlert('Nouvel utilisateur créé avec succès !');

            $this->redirect('auth!login');
        }
        return $this->render('admin/user/index.twig');

    }

    public function updateMethod()
    {
        if ($this->session->islogged()) {
            if (!empty($this->post)) {
                $data['password']   = password_hash($this->post['password'], PASSWORD_DEFAULT);
                $data['login']   = $this->post['login'];
                $data['email']  = $this->post['email'];

                ModelFactory::getModel('User')->updateData($this->get['id'], $data);
                $this->cookie->createAlert('Modification réussie de l\'utilisateur sélectionné !');

                $this->redirect('user!index');
            }
            $user = ModelFactory::getModel('User')->readData($this->get['id']);

            return $this->render('admin/user/update.twig', ['user' => $user]);
        }
    }

    public function deleteMethod()
    {
        if ($this->session->islogged()) {
            ModelFactory::getModel('User')->deleteData($this->get['id']);
            $this->cookie->createAlert('Utilisateur définitivement supprimé !');

            $this->logoutMethod();
        }
        $this->redirect('user!index');

    }

    /**
     * showMethod
     *
     * @return void
     */
    public function showMethod()
    {
        if ($this->session->islogged()) {
            $user = ModelFactory::getModel('User')->readData($this->get['id']);

            return $this->render('admin/user/show.twig', ['user' => $user]);
        }
    }
}