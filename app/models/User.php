<?php


namespace Dex\Microblog\Models;


use Phalcon\Mvc\Model;

class User extends Model
{

    public string $id;
    public string $username;
    public string $fullname;
    public string $email;
    public string $password;
    public string $role_id;
    public string $created_at;
    public string $updated_at;

    public function initialize()
    {
        $this->setReadConnectionService('db');
        $this->setWriteConnectionService('db');

        $this->setSchema('dbo');
        $this->setSource('users');

        $this->belongsTo('role_id', Role::class, 'id');
    }

    public function onConstruct()
    {

    }

//    public function


}
