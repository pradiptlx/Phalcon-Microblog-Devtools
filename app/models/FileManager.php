<?php


namespace Dex\Microblog\Models;


use Phalcon\Mvc\Model;

class FileManager extends Model
{
    public string $id;
    public string $filename;
    public string $path;
    public string $post_id;

    public function initialize(){
        $this->setSchema('dbo');
        $this->setSource('file_manager');


    }

}
