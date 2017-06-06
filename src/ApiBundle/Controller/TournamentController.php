<?php

namespace ApiBundle\Controller;

use ApiBundle\ApiResources\ResponseBuilder\ApiResponseFactory;
use ApiBundle\Entity\Tournament;
use ApiBundle\Managers\TournamentManager;
use ApiBundle\Requests\Tournament\AnnounceTournamentRequest;
use ApiBundle\Requests\Tournament\JoinTournamentRequest;
use ApiBundle\Requests\Tournament\ResultTournamentRequest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use ApiBundle\Annotations\API;

/**
 * Class TournamentController
 * @package ApiBundle\Controller
 */
class TournamentController extends Controller {

    /**
     * @Route("/announceTournament")
     * @Method("GET")
     * @Api\RequestBuilder("Tournament\AnnounceTournamentResource")
     */
    public function announceTournamentAction(
        Tournament $tournament,
        AnnounceTournamentRequest $request,
        ApiResponseFactory $response
    ) {
        $tournament->setAnnounced(true)->setEntryDeposit($request->deposit);
        return $response->setStatusCode(201);
    }

    /**
     * @Route("/joinTournament")
     * @Method("GET")
     * @Api\RequestBuilder("Tournament\JoinTournamentResource")
     */
    public function joinTournamentAction(
        Tournament $tournament,
        JoinTournamentRequest $request,
        ApiResponseFactory $response
    ) {
        /** @var TournamentManager $manager */
        $manager = $this->get('tournament.resource.manager');
        $manager->joinPlayer($tournament, $request->playerId, $request->backerIds);
        return $response->setStatusCode(201);
    }

    /**
     * @Route("/resultTournament")
     * @Method("POST")
     * @Api\RequestBuilder("Tournament\ResultTournamentResource")
     */
    public function resultTournamentAction(
        Tournament $tournament,
        ResultTournamentRequest $request,
        ApiResponseFactory $response
    ) {
        /** @var TournamentManager $manager */
        $manager = $this->get('tournament.resource.manager');
        $manager->announceResults($tournament, $request->winners);
        return $response->setStatusCode(201);
    }
}