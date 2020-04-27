<?php


namespace Dex\Microblog\Models;


use DateTimeInterface;
use Phalcon\Mvc\Model;
use Ramsey\Uuid\Uuid;

class Post extends Model
{
    public string $id;
    public string $title;
    public string $content;
    public int $repost_counter;
    public int $share_counter;
    public int $reply_counter;
    public string $created_at;
    public string $updated_at;
    public string $user_id;
    public string $previous_post_id;

    public function initialize()
    {
        $this->setSchema('dbo');
        $this->setSource('posts');

        $this->belongsTo('user_id', User::class, 'id');
        $this->hasMany('id', ReplyPost::class, 'post_id');
    }

    public function onConstruct()
    {
        $this->id = Uuid::uuid4()->toString();
    }

    public function afterFetch()
    {
        $this->created_at = (new \DateTime())->format('Y-m-d H:i:s');
    }

    public function beforeUpdate(){
        $this->updated_at = (new \DateTime())->format('Y-m-d H:i:s');
    }

    private function incRepostCounter(): int
    {
        return $this->repostCounter++;
    }

    private function incShareCounter(): int
    {
        return $this->shareCounter++;
    }

    private function incReplyCounter(): int
    {
        return $this->reply_counter++;
    }

}
