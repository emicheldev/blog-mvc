<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Model\Factory\ModelFactory;

/**
 * Class CommentController
 * @package App\Controller
 */
class CommentController extends Controller
{
    public function indexMethod()
    {
        if ($this->session->islogged()) {
            $allComments = ModelFactory::getModel('Comment')->listData();
            
            return $this->render('admin/comment/index.twig', ['allComments' => $allComments]);
        }

       $this->redirect('auth');
    }

    public function createMethod()
    {
        if ($this->session->islogged()) {

            $data['article_id']   = $this->get['id'];
            $data['content']      = $this->post['content'];
            $data['createdAt']    = $this->post['date'];
            $data['user_id']      = $this->session['user_id'];
            $data['updateAt']     = $this->post['date'];

            ModelFactory::getModel('Comment')->createData($data);

            $this->cookie->createAlert('Nouveau commentaire créé avec succès !');

            $this->redirect('article!show', ['id' => $this->get['id']]);
        }
        $this->cookie->createAlert('Vous devez être connecté pour ajouter un commentaire...');

        $this->redirect('user!login');
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
                $data['content']      = $this->post['content'];

                ModelFactory::getModel('Comment')->updateData($this->get['id'], $data);

                $this->redirect('article!show', ['id' => $this->post['article_id']]);
            }
            $this->cookie->createAlert('Commentaire modifier !');
            $comment = ModelFactory::getModel('Comment')->readData($this->get['id']);

            return $this->render('blog/update.twig', ['comment' => $comment,'article_id' => $this->get['article_id']]);
        }
        $this->redirect('auth');

    }

    public function updateBackendMethod()
    {
        if ($this->session->islogged()) {
            if (!empty($this->post)) {
                $data['content']      = $this->post['content'];

                ModelFactory::getModel('Comment')->updateData($this->get['id'], $data);

                $this->redirect('comment!index');
            }
            $this->cookie->createAlert('Commentaire modifier !');
            $comment = ModelFactory::getModel('Comment')->readData($this->get['id']);

            return $this->render('admin/comment/update.twig', ['comment' => $comment]);
        }
        $this->redirect('auth');

    }


    public function updateStatutMethod()
    {
        if ($this->session->islogged()) {
            if (!empty($this->get)) {
                $data['publish']      = $this->get['publish'];

                ModelFactory::getModel('Comment')->updateData($this->get['id'], $data);

            }
            $this->cookie->createAlert('Statut du Commentaire modifier !');

            $this->redirect('comment!index');
        }
        $this->redirect('auth');

    }


    public function deleteMethod()
    {
        if ($this->session->islogged()) {
            ModelFactory::getModel('Comment')->deleteData($this->get['id']);
            $this->cookie->createAlert('Commentaire définitivement supprimé !');

            $this->redirect('article!show', ['id' => $this->get['article_id']]);
        }
    }

    public function deleteBackMethod()
    {
        if ($this->session->islogged()) {
            ModelFactory::getModel('Comment')->deleteData($this->get['id']);
            $this->cookie->createAlert('Commentaire définitivement supprimé !');

            $this->redirect('comment!index');
        }
    }
}