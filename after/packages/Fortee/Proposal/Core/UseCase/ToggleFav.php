<?php

namespace Fortee\Proposal\Core\UseCase;

use Fortee\Proposal\Core\Exception\NotFoundException;
use Fortee\Proposal\Core\Model\ProposalFav;
use Fortee\Proposal\Core\Port\ToggleFavPort;

final class ToggleFav
{
    private ToggleFavPort $port;

    /**
     * @param ToggleFavPort $port
     */
    public function __construct(ToggleFavPort $port)
    {
        $this->port = $port;
    }

    public function run(string $uuid, string $on, int $userId)
    {
        if (!$uuid) {
            throw new NotFoundException('Uuid not found');
        }
        $proposal = $this->port->findProposal($uuid);
        if (!$proposal) {
            throw new NotFoundException('Proposal not found');
        }

        $data = [];
        $data['uuid'] = $proposal->getUuid();

        $proposalFav = $this->port->findProposalFav($proposal->getId(), $userId);

        if ($on == 'true') {
            if (!$proposalFav) {
                $proposalFav = new ProposalFav(
                    $proposal->getId(),
                    $userId
                );
            }
            $this->port->saveProposalFav($proposalFav);
            $data['on'] = true;
        } else {
            if ($proposalFav) {
                $this->port->deleteProposalFav($proposalFav);
            }
            $data['on'] = false;
        }

        return $data;
    }
}
