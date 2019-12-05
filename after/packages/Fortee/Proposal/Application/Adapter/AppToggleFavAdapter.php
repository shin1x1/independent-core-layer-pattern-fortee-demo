<?php

namespace Fortee\Proposal\Application\Adapter;

use App\Model\Entity\ProposalFav as ProposalFavEntity;
use App\Model\Table\ProposalFavsTable;
use App\Model\Table\ProposalsTable;
use Fortee\Proposal\Core\Model\Proposal;
use Fortee\Proposal\Core\Model\ProposalFav;
use Fortee\Proposal\Core\Port\ToggleFavPort;

final class AppToggleFavAdapter implements ToggleFavPort
{
    private ProposalsTable $proposals;
    private ProposalFavsTable $proposalFavs;

    /**
     * @param ProposalsTable $proposals
     * @param ProposalFavsTable $proposalFavs
     */
    public function __construct(ProposalsTable $proposals, ProposalFavsTable $proposalFavs)
    {
        $this->proposals = $proposals;
        $this->proposalFavs = $proposalFavs;
    }

    /**
     * @param string $uuid
     * @return Proposal|null
     */
    public function findProposal(string $uuid): ?Proposal
    {
        $entity = $this->proposals->getByUuid($uuid);
        if ($entity === null) {
            return null;
        }

        return new Proposal($entity->id, $entity->uuid);
    }

    /**
     * @param int $proposalId
     * @param int $userId
     * @return ProposalFav|null
     */
    public function findProposalFav(int $proposalId, int $userId): ?ProposalFav
    {
        /** @var ProposalFavEntity $entity */
        $entity = $this->proposalFavs->find()
            ->where([
                'proposal_id' => $proposalId,
                'user_id'     => $userId,
            ])
            ->first();

        if ($entity === null) {
            return null;
        }

        return new ProposalFav(
            $entity->user_id, $entity->proposal_id, $entity->id
        );
    }

    /**
     * @param ProposalFav $proposalFav
     */
    public function saveProposalFav(ProposalFav $proposalFav)
    {
        $entity = new ProposalFavEntity([
            'proposal_id' => $proposalFav->getProposalId(),
            'user_id'     => $proposalFav->getUserId(),
        ]);
        if ($proposalFav->getId() !== null) {
            $entity->id = $proposalFav->getId();
            $entity->isNew(false);
        }

        $this->proposalFavs->save($entity);
    }

    /**
     * @param ProposalFav $proposalFav
     */
    public function deleteProposalFav(ProposalFav $proposalFav)
    {
        $entity = new ProposalFavEntity();
        $entity->id = $proposalFav->getId();
        $entity->isNew(false);

        $this->proposalFavs->delete($entity);
    }
}
