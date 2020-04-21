<?php


namespace Dex\Microblog\Models;

class UserModel
{

    /**
     * @var UserId $id
     * Generated by UUID
     */
    protected UserId $id;

    protected string $username;

    protected string $fullName;

    protected string $email;

    protected string $numberOfPost;

    /**
     * @var RoleModel $roleUser
     *
     */
    protected RoleModel $roleUser;

    protected string $password;

    /**
     * UserModel constructor.
     * @param UserId $id
     * @param string $username
     * @param string $fullName
     * @param string $email
     * @param string $password
     * @param RoleModel $roleUser
     */
    public function __construct(
        UserId $id,
        string $username,
        string $fullName,
        string $email,
        string $password,
        RoleModel $roleUser
    )
    {
        $this->id = $id;
        $this->username = $username;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->password = $password;
        $this->roleUser = $roleUser;

    }

    public function getRoleUser()
    {
        return $this->roleUser->getRole();
    }

    public function getPermissionUser()
    {

        return $this->roleUser->getPermission();
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getFullname(): string
    {
        return $this->fullName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoleModel(): RoleModel
    {
        return $this->roleUser;
    }

    /**
     * @param string $role
     * @return RoleModel
     */
    // TODO: Setter role
    public function setRoleUser(string $role): RoleModel
    {
        $this->roleUser->setRole($role);

        return $this->roleUser;
    }

    /**
     * @param array $perm
     */
    // TODO: Setter perm user
    public function setPermissionUser(array $perm = null)
    {
        $this->roleUser->setListPermission($perm);
    }

}