<?php

namespace ApiBundle\Controller;

use ApiBundle\ApiResources\ResponseBuilder\ApiResponseFactory;
use ApiBundle\Entity\Player;
use ApiBundle\Requests\Player\FundPointsRequest;
use ApiBundle\Requests\Player\TakePointsRequest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use ApiBundle\Annotations\API;
use Symfony\Component\HttpFoundation\JsonResponse;

class PlayerController extends Controller
{
    /**
     * @Route("/take")
     * @Method("GET")
     * @Api\RequestBuilder("Player\TakePointsResource")
     */
    public function takePointsAction(Player $player, TakePointsRequest $request, ApiResponseFactory $response) {
        $player->takeBonusPoints($request->amount);
        return $response->setStatusCode(201);
    }

    /**
     * @Route("/fund")
     * @Method("GET")
     * @Api\RequestBuilder("Player\FundPointsResource")
     */
    public function fundPointsAction(Player $player, FundPointsRequest $request, ApiResponseFactory $response) {
        $player->addBonusPoints($request->amount);
        return $response->setStatusCode(201);
    }

    /**
     * @Route("/balance")
     * @Method("GET")
     * @Api\RequestBuilder("Player\PlayerBalanceResource")
     */
    public function balanceAction(Player $player, ApiResponseFactory $response) {
        return $response->set('playerId', 'P' . $player->getId())->set('balance', $player->getBonusPoints());
    }
}
