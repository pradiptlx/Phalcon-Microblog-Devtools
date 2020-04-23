<?php
declare(strict_types=1);

namespace Dex\Microblog\Controller;

use Dex\Microblog\Models\Role;
use Dex\Microblog\Models\RoleId;
use Dex\Microblog\Models\RoleModel;
use Dex\Microblog\Models\User;
use Dex\Microblog\Models\UserId;
use Dex\Microblog\Models\UserModel;
use http\Exception\InvalidArgumentException;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Controller;
use Ramsey\Uuid\Uuid;

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
            $rolename = $request->getPost('rolename', 'string') ?: 'admin';

            $user = new User();

            $roleQuery = "SELECT id, rolename, permissions
                            FROM roles
                            WHERE rolename=:rolename";
            $result_role = $this->db->query($roleQuery, [
                'rolename' => $rolename
            ]);

            $role = $result_role->fetch();
            if(!isset($role)){
                $roleModel = new Role();
                $roleModel->assign([
                   'id' => Role::getRoleId($rolename),
                   'rolename' => $rolename,
                   'permissions' => Role::getPerms()
                ]);
                if(!$roleModel->create())
                    return new \Exception("Can't create new role");
            }

            // TODO: Change default rolename
            $user->assign([
                'id' => Uuid::uuid4()->toString(),
                'username' => $username,
                'fullname' => $fullname,
                'email' => $email,
                'password' => $password,
                'role_id' => Role::getRoleId('admin'),
                (new \DateTime())->format('Y-m-d H:i:s')
            ]);

            if ($user->create()) {
               $this->flash->success("Registration success");

               return $this->response->redirect('/home');
            }

        }

        // TODO: Redirect to view
        return $this->view->pick('user/register');
    }

    public function loginAction()
    {
        $headerCollection = $this->assets->collection('headerCss');
        $headerCollection->addCss('/css/login/main.css');
        $headerCollection->addCss('/css/login/index.css');

        $request = $this->request;

        if ($request->isPost()) {
            $username = $request->getPost('username', 'string');
            $fullname = $request->getPost('fullname', 'string');
            $email = $request->getPost('email', 'string');
            $password = $request->getPost('password', 'string');

//            return $this->view->pick("user/login");
        } else if ($request->isGet()) {
            $this->view->title = "Login page";

//            $this->view->start()->render('user','login');
            $this->view->pick('layouts/base');
            $this->view->pick("user/login");
//            $this->view->render('user', 'login');
        }
        new \Exception("Test");
    }

    public function forgotPasswordAction()
    {
        $request = $this->request;
    }

}

