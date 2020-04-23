<?php


namespace Dex\Microblog\Models;


use Phalcon\Mvc\Model;
use Ramsey\Uuid\Uuid;

class Role extends Model
{
    public string $id;
    public string $rolename;
    public array $permissions;

    public static string $PERM_READ = 'read';
    public static string $PERM_WRITE = 'write';
    public static string $PERM_COMMENT = 'comment';

    public static string $ROLE_KEY = 'role_';

    public function initialize(){
        $this->setSchema('dbo');
        $this->setSource('roles');
    }

    public function onConstruct(){

    }

    public static function getRoleId(string $rolename = ""){
        return Uuid::uuid3(self::$ROLE_KEY, $rolename)->toString();
    }

    // TODO : For guest and general
    public static function getPerms(){
        return json_encode([
            self::$PERM_WRITE,
            self::$PERM_COMMENT,
            self::$PERM_READ
        ]);
    }

}
