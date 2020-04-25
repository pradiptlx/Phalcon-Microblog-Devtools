<?php
declare(strict_types=1);

namespace Dex\Microblog\Controller;

use Dex\Microblog\Models\FileManager;
use Dex\Microblog\Models\Post;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Query;
use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Mvc\Model\Transaction\Manager;

class PostController extends Controller
{

    public function initialize()
    {
        if (!$this->session->has('user_id')) {
            $this->flash->error("You must login.");
            $this->response->redirect('/user/login');
        }

        $postCssCollection = $this->assets->collection('postCss');
        $postCssCollection->addCss('/css/main.css');
    }

    public function indexAction()
    {

        $this->view->title = "Home";

        //TODO: JOIN USER
//        $query = "SELECT p.id, p.title, p.content, p.created_at, p.updated_at, p.repost_counter, p.share_counter, u.fullname
//                    FROM posts p
//                    JOIN users u on p.user_id = u.id";
//
//        $createQuery = new Query($query, $this->di);
//
//        $posts = $createQuery->execute();
        $posts = Post::find();

        $urls = [];

        foreach ($posts as $post){
            $urls[] = $this->url->get([
               'for' => 'view-post',
               'title' => 'View Post',
               'params' => $post->id
            ]);
        }
        $this->view->setVar('posts', $posts);
        $this->view->setVar('links', $urls);

        return $this->view->pick('post/home');
    }

    public function createPostAction()
    {
        $this->view->setVar('title', 'Create Post');
        $request = $this->request;

        if ($request->isPost()) {
            $title = $request->getPost('title', 'string');
            $content = $request->getPost('content', 'string');
            $files = $request->getPost('files', 'array') ?: [];
            $user_id = $this->session->get('user_id');

            try {
                $manager = new Manager();
                $transaction = $manager->get();

                $postModel = new Post();
                $postModel->setTransaction($transaction);
                $postModel->title = $title;
                $postModel->content = $content;

                if (isset($files)) {
                    foreach ($files as $file) {
                        $this->initializeFileManager($file, $postModel->id);

                    }
                }
                $postModel->user_id = $user_id;
                $postModel->created_at = (new \DateTime('now'))->format('Y-m-d H:i:s');
                $postModel->updated_at = (new \DateTime('now'))->format('Y-m-d H:i:s');

                if (!$postModel->save()) {
                    $transaction->rollback('Can not save post');
                    $this->flash->error('Can not save post');
                    $this->response->redirect('/home');
                } else
                    $transaction->commit();

                $this->flash->success('Create post success');
                $this->response->redirect('/home');

            } catch (Failed $exception) {
                $this->flash->error($exception->getMessage());

            }

        }

    }

    private function initializeFileManager(array $file, $post_id)
    {
        $fileModel = new FileManager();
        try {
            $manager = new Manager();
            $trx = $manager->get();

            $fileModel->file_name = $file['filename'];
            $fileModel->path = '';
            $fileModel->post_id = $post_id;
            if (!$fileModel->save()) {
                $trx->rollback('Can not save file on file manager');
            } else {
                $trx->commit();
            }
        } catch (Failed $exception) {
            $this->flash->error($exception->getMessage());

        }
    }

}

