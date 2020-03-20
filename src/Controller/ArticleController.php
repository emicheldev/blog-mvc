<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ArticleController
 * @package App\Controller
 */
class ArticleController extends Controller
{
     /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $allArticles = ModelFactory::getModel('Article')->listData();

        return $this->render('blog/index.twig', ['allArticles' => $allArticles]);
    }

    /**
     * indexMethod
     *
     * @return void
     */
    public function indexMethod()
    {

        if ($this->session->islogged()) {
            $allArticles = ModelFactory::getModel('Article')->listData();

            return $this->render('admin/blog/index.twig', ['allArticles' => $allArticles]);
        }

        $this->redirect('auth');

     
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createMethod()
    {
        if ($this->session->islogged()) {
            if (!empty($this->post)) {
                $data['title']        = $this->post['title'];
                $data['content']      = $this->post['content'];
                $data['createdAt']    = $this->post['date'];
                $data['updatedAt']    = $this->post['date'];
                $data['user_id']      = $this->session->get('user');


                ModelFactory::getModel('Article')->createData($data);
                $this->cookie->createAlert('Nouvel article créé avec succès !');

                $this->redirect('article!index');
            }
            return $this->render('admin/blog/create.twig');
        }
        $this->redirect('auth');

    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function showMethod()
    {
        $article    = ModelFactory::getModel('Article')->readData($this->get['id']);
        $article    += ModelFactory::getModel('User')->readData($article['user_id']);
        $comments   = ModelFactory::getModel('Comment')->listData($this->get['id'], 'article_id');


        if(!empty($comments)) {

            for ($i = 0; $i < count($comments); $i++) {

                $userId = $comments[$i]['user_id'];
                $user   = ModelFactory::getModel('User')->readData($userId);

                $comments[$i]['user']   = $user['login'];
            }
        } 

        return $this->render('blog/show.twig', [
            'article'   => $article,
            'comments'  => $comments
        ]);
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function updateMethod()
    {
        if ($this->session->islogged()) {
            if (!empty($this->post)) {
                $data['title']        = $this->post['title'];
                $data['content']      = $this->post['content'];

                ModelFactory::getModel('Article')->updateData($this->get['id'], $data);

                $this->redirect('admin');
            }
            $this->cookie->createAlert('Article définitivement supprimé !');
            $article = ModelFactory::getModel('Article')->readData($this->get['id']);

            return $this->render('admin/blog/update.twig', ['article' => $article]);
        }
        $this->redirect('auth');

    }

    public function deleteMethod()
    {
        if ($this->session->islogged()) {
            ModelFactory::getModel('Article')->deleteData($this->get['id']);
            $this->cookie->createAlert('Article définitivement supprimé !');

            $this->redirect('article!index');
        }
        $this->redirect('auth');

    }
}