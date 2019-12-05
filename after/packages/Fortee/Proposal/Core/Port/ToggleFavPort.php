<?php

namespace Fortee\Proposal\Core\Port;

use Fortee\Proposal\Core\Model\Proposal;
use Fortee\Proposal\Core\Model\ProposalFav;

interface ToggleFavPort
{
    public function findProposal(string $uuid): ?Proposal;

    public function findProposalFav(int $proposalId, int $userId): ?ProposalFav;

    public function saveProposalFav(ProposalFav $proposalFav);
    public function deleteProposalFav(ProposalFav $proposalFav);
}
