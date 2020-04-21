<?php


namespace Dex\Microblog\Models;

use Ramsey\Uuid\Uuid;

class UserId
{

    private string $id;

    public function __construct($id = "")
    {
        $this->id = $id ?: Uuid::uuid4()->toString();
    }

    public function getId()
    {
        return $this->id;
    }

    public function isEqual(UserId $userId): bool
    {
        return $this->id === $userId;
    }

}
