<?php


namespace Dex\Microblog\Models;


use Ramsey\Uuid\Uuid;

class PostId
{
    /**
     * @var string $id
     */
    protected string $id;

    public function __construct($id = null)
    {
        $this->id = Uuid::uuid4()->toString();
    }

    public function getId()
    {
        return $this->id;
    }

    public function isEqual(PostId $postId): bool
    {
        return $this->id === $postId;
    }

}
