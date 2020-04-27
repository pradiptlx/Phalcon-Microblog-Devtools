<?php


namespace Dex\Microblog\Models;


use Phalcon\Mvc\Model;

class ReplyPost extends Model
{
    public string $id;
    public string $content;
    public string $post_id;
    public string $user_id;
    public ?string $created_at = null;
    public ?string $updated_at = null;

    public function initialize()
    {
        $this->setSchema('dbo');
        $this->setSource('reply_post');

        $this->belongsTo('post_id', Post::class, 'id');
        $this->belongsTo('user_id', User::class, 'id');
    }

    public function beforeSave()
    {
        $this->created_at = (new \DateTime())->format('Y-m-d H:i:s');
    }

    public function beforeUpdate()
    {
        $this->updated_at = (new \DateTime())->format('Y-m-d H:i:s');
    }

}
