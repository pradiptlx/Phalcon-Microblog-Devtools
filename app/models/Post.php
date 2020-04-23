<?php


namespace Dex\Microblog\Models;


use Phalcon\Mvc\Model;

class Post extends Model
{
    public string $id;
    public string $title;
    public string $content;
    public string $created_at;
    public string $updated_at;
    public User $user_id;

    public function initialize(){
        $this->setSchema('dbo');
        $this->setSource('posts');
    }

}
