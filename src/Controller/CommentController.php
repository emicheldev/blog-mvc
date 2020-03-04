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
    public function createMethod()
    {
        if ($this->session->islogged()) {

            $data['article_id']   = $this->get['id'];
            $data['content']      = $this->post['content'];
            $data['createdAt'] = $this->post['date'];
            $data['user_id']      = $_SESSION['user']['id'];
            $data['date_last_modif']      = $this->post['date'];

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
    }

    public function deleteMethod()
    {
        if ($this->session->islogged()) {
            ModelFactory::getModel('Comment')->deleteData($this->get['id']);
            $this->cookie->createAlert('Commentaire définitivement supprimé !');

            $this->redirect('article!show', ['id' => $this->get['article_id']]);
        }
    }
}