<?php
declare(strict_types=1);

namespace Dex\Microblog\Controller;

use Dex\Microblog\Models\FileManager;
use Dex\Microblog\Models\Post;
use Dex\Microblog\Models\ReplyPost;
use Phalcon\Db\Exception;
use Phalcon\Http\Request\File;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Query;
use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Mvc\Model\Transaction\Manager;
use Ramsey\Uuid\Uuid;

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
        $query = "SELECT p.id, p.title, p.content, p.created_at, p.updated_at, p.repost_counter, p.share_counter, u.fullname
                    FROM Dex\Microblog\Models\Post p
                    JOIN Dex\Microblog\Models\User u on p.user_id = u.id";

        $createQuery = new Query($query, $this->di);

        $posts = $createQuery->execute();
//        $posts = Post::find();

        $files = [];
        $urls = [];

        foreach ($posts as $post) {
            $urls[] = $this->url->get([
                'for' => 'view-post',
                'title' => 'View Post',
                'params' => $post->id
            ]);

            $query = "SELECT f.*
                        FROM Dex\Microblog\Models\FileManager f
                        WHERE f.post_id=:post_id:";
            $createQuery = new Query($query, $this->di);

            $files[] = $createQuery->execute([
                'post_id' => $post->id
            ])->getFirst();
        }

//        foreach ($files as $file) {
//            $data[] = $file;
//        }
//        var_dump($data);
//        die();
//        var_dump($files);
//        die();
        $this->view->setVar('files', $files);
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

            $user_id = $this->session->get('user_id');

            try {
                $manager = new Manager();
                $transaction = $manager->get();

                $postModel = new Post();
                $postModel->setTransaction($transaction);
                $postModel->title = $title;
                $postModel->content = $content;

                if ($this->request->hasFiles()) {
                    $files = $request->getUploadedFiles() ?: [];
                    foreach ($files as $file) {
                        $this->initializeFileManager($file, $postModel->id, $user_id);
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

    public function viewPostAction()
    {
        $request = $this->request;

        $idPost = $this->router->getParams()[0];

        if (isset($idPost)) {
            if ($request->isGet()) {
                $query = "SELECT p.id, p.title, p.content, p.created_at, p.updated_at, 
                p.repost_counter, p.share_counter, u.fullname
                FROM Dex\Microblog\Models\Post p
                JOIN Dex\Microblog\Models\User u on p.user_id = u.id
                WHERE p.id = :id:";
                //TODO: Exception UUID not found -> some solution: hardcode parameter to use 16bytes GUID
                $modelManager = $this->modelsManager->createQuery($query);
                $post = $modelManager->execute(
                    [
                        'id' => $idPost
                    ]
                )->getFirst();

                $replyQuery = "SELECT r.id as RepId, r.content as RepContent,
                 r.user_id as RepUser, r.created_at as RepCreatedAt, u.fullname as RepFullname
                FROM Dex\Microblog\Models\ReplyPost r
                JOIN Dex\Microblog\Models\User u on r.user_id = u.id
                WHERE r.post_id = :id:";
                $modelManager = $this->modelsManager->createQuery($replyQuery);
                $replies = $modelManager->execute([
                    'id' => $idPost
                ]);
//                var_dump($replies);
//                die();

                $this->view->setVar('replies', $replies);
                $this->view->setVar('title', $post->title);
                $this->view->setVar('post', $post);

                return $this->view->pick('post/viewPost');

            } elseif ($request->isPost()) {
                $content = $request->getPost('content', 'string');
                $userId = $this->session->get('user_id');
                // Reply
                $this->db->begin();

                $replyModel = new ReplyPost();
                $replyModel->id = Uuid::uuid4()->toString();
                $replyModel->content = $content;
                $replyModel->user_id = $userId;
                $replyModel->post_id = $idPost;

                if (!$replyModel->save()) {
                    $this->db->rollback();
                    $this->flash->error("Failed to reply");
                    return $this->response->redirect('/post/viewPost/' . $idPost);
                }

                $this->db->commit();
                return $this->response->redirect('/post/viewPost/' . $idPost);
            }
        }

        $this->dispatcher->forward([
            'controller' => 'post',
            'action' => 'index'
        ]);
    }

    public function replyPostAction()
    {
        $request = $this->request;

        if ($request->isPost()) {
            $content = $request->getPost('content', 'string');
            $postId = $this->router->getParams()[0];
            $userId = $this->session->get('user_id');

            if (isset($postId) && isset($userId)) {
                $this->db->begin();
                $replyModel = new ReplyPost();
                $replyModel->id = Uuid::uuid4()->toString();
                $replyModel->content = $content;
                $replyModel->post_id = $postId;
                $replyModel->user_id = $userId;
                $replyModel->created_at = (new \DateTime())->format('Y-m-d H:i:s');
                $replyModel->updated_at = (new \DateTime())->format('Y-m-d H:i:s');;

                //TODO: Fix model event not work
                if (!$replyModel->save()) {
                    $this->db->rollback();
                    $this->flash->error("Error Reply");
                    return $this->response->redirect('/home');
                }
                $this->db->commit();
            }

        } else {
            $this->flash->error("Doesn't Support GET Method");
        }

        return $this->response->redirect('/home');
    }

    public function replyOfReplyAction()
    {
        $request = $this->request;

        $postId = $this->dispatcher->getParam('postId');
        $replyId = $this->dispatcher->getParam('replyId');

        if ($request->isPost() && isset($postId) && isset($replyId)) {

            $content = $request->getPost('content', 'string');
            $userId = $this->session->get('user_id');

            $this->db->begin();
            try {
                $replyModel = new ReplyPost();
                $replyModel->id = Uuid::uuid4()->toString();
                $replyModel->content = $content;
                $replyModel->user_id = $userId;
                $replyModel->post_id = $replyId;
                $replyModel->created_at = (new \DateTime())->format('Y-m-d H:i:s');

                if (!$replyModel->save()) {
                    $this->db->rollback();
                    throw new Failed("Failed to store reply of reply");
                }

                //TODO: Reply of reply
                $this->db->commit();
                $this->flash->success("Reply Success");

            } catch (Failed $exception) {
                $this->flash->error($exception->getMessage());
                return $this->response->redirect('/post/viewPost/' . $postId);
            }

        }

        return $this->response->redirect('/post/viewPost/' . $postId);
    }

    private function initializeFileManager(File $file, string $post_id, string $user_id)
    {
        $fileModel = new FileManager();
        try {
            $manager = new Manager();
            $trx = $manager->get();

            $this->url->setBasePath('/files/');
            $path = $user_id . "/" . $post_id . "/" . $file->getName();
            try {
                if (!mkdir('files/' . $user_id . "/" . $post_id, 0755, true)) {
                    throw new \Phalcon\Url\Exception("Failed to mkdir");
                }
                $file->moveTo('files/' . $path);
            } catch (\Phalcon\Url\Exception $exception) {
                var_dump($exception->getMessage());
                die();
            }

            $fileModel->file_name = $file->getName();
            $fileModel->path = "/files/" . $path;
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

