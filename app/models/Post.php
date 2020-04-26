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
    public int $repostCounter;
    public int $shareCounter;
    public string $created_at;
    public string $updated_at;
    public string $user_id;
    public string $previous_post_id;

    public function initialize()
    {
        $this->setSchema('dbo');
        $this->setSource('posts');

        $this->belongsTo('user_id', User::class, 'id');
    }

    public function onConstruct()
    {
        $this->id = Uuid::uuid4()->toString();
    }

    public function afterFetch(){
        $this->created_at = (new \DateTime($this->created_at))->format(DateTimeInterface::COOKIE);
    }

    private function incRepostCounter(): int
    {
        return $this->repostCounter++;
    }

    private function incShareCounter(): int
    {
        return $this->shareCounter++;
    }

}
