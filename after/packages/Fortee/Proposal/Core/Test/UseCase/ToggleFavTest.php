<?php

namespace Fortee\Proposal\Core\Test\UseCase;

use BadMethodCallException;
use Fortee\Proposal\Core\Model\Proposal;
use Fortee\Proposal\Core\Model\ProposalFav;
use Fortee\Proposal\Core\Port\ToggleFavPort;
use Fortee\Proposal\Core\UseCase\ToggleFav;
use PHPUnit\Framework\TestCase;

final class ToggleFavTest extends TestCase
{
    /**
     * @test
     */
    public function fav()
    {
        $adapter = new class implements ToggleFavPort {

            public function findProposal(string $uuid): ?Proposal
            {
                return new Proposal(1, $uuid);
            }

            public function findProposalFav(int $proposalId, int $userId): ?ProposalFav
            {
                return null;
            }

            public function saveProposalFav(ProposalFav $proposalFav)
            {
            }

            public function deleteProposalFav(ProposalFav $proposalFav)
            {
                throw new BadMethodCallException();
            }
        };


        $sut = new ToggleFav($adapter);
        $actual = $sut->run('uuid1', 'true', 1);

        $expected = [
            'uuid' => 'uuid1',
            'on' => true,
        ];

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function unfav()
    {
       $adapter = new class implements ToggleFavPort {

           public function findProposal(string $uuid): ?Proposal
           {
               return new Proposal(1, $uuid);
           }

           public function findProposalFav(int $proposalId, int $userId): ?ProposalFav
           {
               return new ProposalFav(1, 2, 3);
           }

           public function saveProposalFav(ProposalFav $proposalFav)
           {
               throw new BadMethodCallException();
           }

           public function deleteProposalFav(ProposalFav $proposalFav)
           {
           }
       };

        $sut = new ToggleFav($adapter);
        $actual = $sut->run('uuid1', 'false', 1);

        $expected = [
            'uuid' => 'uuid1',
            'on' => false,
        ];

        $this->assertSame($expected, $actual);
    }
}






