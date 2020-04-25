<?php


namespace Dex\Microblog\Models;


use Phalcon\Mvc\Model;
use Ramsey\Uuid\Uuid;

class FileManager extends Model
{
    public string $id;
    public string $file_name;
    public string $path;
    public string $post_id;

    public function initialize()
    {
        $this->setSchema('dbo');
        $this->setSource('file_manager');


        $this->belongsTo('post_id', Post::class, 'id');
    }

    public function onConstruct()
    {
        $this->id = Uuid::uuid4()->toString();
    }

}
