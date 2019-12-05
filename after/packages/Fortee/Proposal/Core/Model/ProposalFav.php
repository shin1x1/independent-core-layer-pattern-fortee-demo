<?php

namespace Fortee\Proposal\Core\Model;

final class ProposalFav
{
    private int $proposalId;
    private int $userId;
    private ?int $id;

    /**
     * @param int $proposalId
     * @param int $userId
     * @param int|null $id
     */
    public function __construct(int $proposalId, int $userId, ?int $id = null)
    {
        $this->proposalId = $proposalId;
        $this->userId = $userId;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getProposalId(): int
    {
        return $this->proposalId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }


}
