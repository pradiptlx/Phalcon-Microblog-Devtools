<?php
declare(strict_types=1);

namespace Dex\Microblog\Controller;

use Dex\Microblog\Models\RoleId;
use Dex\Microblog\Models\RoleModel;
use Dex\Microblog\Models\UserId;
use Dex\Microblog\Models\UserModel;
use http\Exception\InvalidArgumentException;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {

    }

    public function registerAction()
    {
        $request = $this->request;

        if ($request->isPost()) {
            $username = $request->getPost('username', 'string');
            $fullname = $request->getPost('fullname', 'string');
            $email = $request->getPost('email', 'string');
            $password = $request->getPost('password', 'string');

            $user = new UserModel(
                new UserId(),
                $username,
                $fullname,
                $email,
                $password,
                new RoleModel(
                    new RoleId(),
                    RoleModel::$USER_ADMIN,
                    RoleModel::createAdmin()
                )
            );
        } else {
            throw new InvalidArgumentException("Wrong Route");
        }

        // TODO: Redirect to view
        return $this->view->pick('');
    }

    public function loginAction()
    {
        $request = $this->request;

        if ($request->isPost()) {
            $username = $request->getPost('username', 'string');
            $fullname = $request->getPost('fullname', 'string');
            $email = $request->getPost('email', 'string');
            $password = $request->getPost('password', 'string');

//            return $this->view->pick("user/login");
        } else if($request->isGet()){
            $this->view->title = "Login page";

            return $this->view->pick("user/login");
        }
    }

    public function forgotPasswordAction() {
        $request = $this->request;
    }

}

