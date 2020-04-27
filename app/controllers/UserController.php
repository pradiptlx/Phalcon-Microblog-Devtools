<?php
declare(strict_types=1);

namespace Dex\Microblog\Controller;

use Dex\Microblog\Models\Role;
use Dex\Microblog\Models\RoleId;
use Dex\Microblog\Models\RoleModel;
use Dex\Microblog\Models\User;
use Dex\Microblog\Models\UserId;
use Dex\Microblog\Models\UserModel;
use Phalcon\Cli\Dispatcher;
use Phalcon\Mvc\Controller;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{

    public function initialize()
    {
        if (is_null($this->router->getActionName())) {
            $this->response->redirect('/user/login');
        }


    }

    public function indexAction()
    {

    }

    public function registerAction()
    {
        $this->view->title = "Register Account";
        $request = $this->request;

        if ($request->isPost()) {
            $username = $request->getPost('username', 'string');
            $fullname = $request->getPost('fullname', 'string');
            $email = $request->getPost('email', 'email');
            $password = $request->getPost('password', 'string');
            $rolename = $request->getPost('rolename', 'string') ?: 'admin';

            $user = new User();

            $roleQuery = "SELECT id, role_name, permissions
                            FROM roles
                            WHERE role_name=:rolename";
            $result_role = $this->db->query($roleQuery, [
                'rolename' => $rolename
            ]);

            $role = $result_role->fetch();

            $roleModel = new Role();
            if (!$role) {
                $roleModel->assign([
                    'id' => Role::getRoleId($rolename),
                    'role_name' => $rolename,
                    'permissions' => Role::getPerms()
                ]);
                if (!$roleModel->create())
                    return new \Exception("Can't create new role");
            }

            // TODO: Change default rolename
            $user->assign([
                'id' => Uuid::uuid4()->toString(),
                'username' => $username,
                'fullname' => $fullname,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'role_id' => Role::getRoleId('admin'),
                'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
                'updated_at' => (new \DateTime())->format('Y-m-d H:i:s')
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
            $password = $request->getPost('password', 'string');

            $user = User::findByUsername($username)->getFirst();

            if ($this->checkingPassword($password, $user->password)) {
                $this->flash->success("Login Success");
                $this->session->set('user_id', $user->id);

                $this->response->redirect('/home');
            } else {
                $this->flash->error("Login Failed");

                return $this->view->pick('user/login');
            }
        } else if ($request->isGet()) {
            $this->view->title = "Login page";

//            $this->view->start()->render('user','login');
            $this->view->pick("user/login");
//            $this->view->render('user', 'login');
        }
        new \Exception("Test");
    }

    public function logoutAction()
    {
        if ($this->di->has('user')) {
            $this->di->remove('user');
        }
        if ($this->session->has('user_id')) {
            $this->session->remove('user_id');
        }

        $this->flash->success("Successfully logout");
        return $this->response->redirect('/user/login');
    }

    public function forgotPasswordAction()
    {
        $request = $this->request;
    }

    private function checkingPassword(string $password, string $passwordDb): bool
    {
        return password_verify($password, $passwordDb);

    }

}

