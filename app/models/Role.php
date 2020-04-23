<?php


namespace Dex\Microblog\Models;


use Phalcon\Mvc\Model;
use Ramsey\Uuid\Uuid;

class Role extends Model
{
    public string $id;
    public string $role_name;
    public string $permissions;

    public static string $PERM_READ = 'read';
    public static string $PERM_WRITE = 'write';
    public static string $PERM_COMMENT = 'comment';

    public static string $ROLE_KEY = 'role_';

    public function initialize()
    {
        $this->setSchema('dbo');
        $this->setSource('roles');

        $this->hasMany('id', User::class,
            'role_id',
            [
                'reusable' => true
            ]);
    }

    public function onConstruct()
    {

    }

    public static function getRoleId(string $rolename = "admin")
    {
        return Uuid::uuid3(Uuid::NAMESPACE_X500, $rolename)->toString();
    }

    // TODO : For guest and general
    public static function getPerms()
    {
        return json_encode([
            self::$PERM_WRITE,
            self::$PERM_COMMENT,
            self::$PERM_READ
        ]);
    }

}
