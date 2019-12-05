<?php
namespace App\Controller;

use App\Adapters\Proposal\AppSingleProposalAdapter;
use App\Adapters\Proposal\AppToggleProposalFavAdapter;
use App\Classes\OembedCore;
use App\Classes\ReservationCore;
use App\Controller\AppController;
use App\Model\Entity\Proposal;
use App\Model\Table\ProposalsTable;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Date;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * Proposals Controller
 *
 * @property \App\Model\Table\ProposalsTable $Proposals
 * @property \App\Model\Table\ProposalFavsTable $ProposalFavs
 * @property \App\Model\Table\AttendeesTable $Attendees
 * @property \App\Model\Table\UsersTable $Users
 */
class ProposalsController extends AppController
{
    public function fav()
    {
        $error = null;

        $data = [];
        do {
            if (! $this->activeUser){
                $error = 'お気に入りに追加するにはログインしてください。';
                break;
            }

            $uuid = $this->request->getData('uuid');
            $on = $this->request->getData('on');
            if (! $uuid){
                throw new NotFoundException('Uuid not found');
            }
            /** @var \App\Model\Entity\Proposal $proposal */
            $proposal = $this->Proposals->getByUuid($uuid);
            if (! $proposal){
                throw new NotFoundException('Proposal not found');
            }
            $data['uuid'] = $proposal->uuid;

            /** @var \App\Model\Entity\ProposalFav $proposalFav */
            $proposalFav = $this->ProposalFavs->find()
                ->where([
                    'proposal_id' => $proposal->id,
                    'user_id' => $this->activeUser->id,
                ])
                ->first();

            if ($on == 'true'){
                if (! $proposalFav){
                    $proposalFav = $this->ProposalFavs->newEntity();
                    $proposalFav->proposal_id = $proposal->id;
                    $proposalFav->user_id = $this->activeUser->id;
                }
                $this->ProposalFavs->save($proposalFav);
                $data['on'] = true;
            } else {
                if ($proposalFav){
                    $this->ProposalFavs->delete($proposalFav);
                }
                $data['on'] = false;
            }
        } while(false);

        $this->viewBuilder()->autoLayout(false);
        $this->autoRender = false;
        $this->response->charset('UTF-8');
        $this->response->type('json');

        if (! $error){
            $this->response->body(json_encode(['result' => 'OK', 'data' => $data]));
        } else {
            $this->response->body(json_encode(['result' => 'ERROR', 'data' => ['error' => $error]]));
        }
        return;
    }
}
