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
use Fortee\Proposal\Application\Adapter\AppToggleFavAdapter;
use Fortee\Proposal\Core\UseCase\ToggleFav;

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

            $adapter = new AppToggleFavAdapter(
                $this->Proposals,
                $this->ProposalFavs
            );

            $useCase = new ToggleFav($adapter);
            $data = $useCase->run(
                $this->request->getData('uuid'),
                $this->request->getData('on'),
                $this->activeUser->id
            );
        } while(false);

        $this->viewBuilder()->autoLayout(false);
        $this->autoRender = false;
        $this->response->charset('UTF-8');
        $this->response->type('json');

        if (! $error){
            $this->response->body(json_encode([
                'result' => 'OK',
                'data' => $data
            ]));
        } else {
            $this->response->body(json_encode([
                'result' => 'ERROR',
                'data' => ['error' => $error]
            ]));
        }
        return;
    }
}
