<?php

namespace Fortee\Proposal\Core\Model;

final class Proposal
{
    private int $id;
    private string $uuid;

    /**
     * @param int $id
     * @param string $uuid
     */
    public function __construct(int $id, string $uuid)
    {
        $this->id = $id;
        $this->uuid = $uuid;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }



}
