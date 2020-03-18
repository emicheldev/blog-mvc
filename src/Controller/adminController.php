<?php

namespace App\Controller;

use App\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class AdminController
 * Manages the Adminpage
 * @package App\Controller
 */
class AdminController extends Controller 
{
     /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        if ($this->session->islogged()) {
            $allArticles = ModelFactory::getModel('Article')->listData();
            $allComments = ModelFactory::getModel('Comment')->listData();
            $allUsers    = ModelFactory::getModel('User')   ->listData();
            
            return $this->render('admin/index.twig', [
            'allArticles'       => $allArticles,
            'allComments'       => $allComments,
            'allUsers'          => $allUsers,
            ]);
        }

        $this->redirect('admin');



    }

}