<?php


namespace Dex\Microblog\Models;


use Ramsey\Uuid\Uuid;

class StatsId
{

    protected string $id;

    public function __construct($id = "")
    {
        $this->id = $id ?: Uuid::uuid4()->toString();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function isEqual(StatsId $statsId): bool
    {
        return $this->id === $statsId;
    }

}
