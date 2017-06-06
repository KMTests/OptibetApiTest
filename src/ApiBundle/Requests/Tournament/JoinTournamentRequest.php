<?php

namespace ApiBundle\Requests\Tournament;

use ApiBundle\ApiResources\RequestFactory\ApiRequestBase;
use Symfony\Component\Validator\Constraints as Assert;
use ApiBundle\Annotations\API;

/**
 * Class JoinTournamentRequest
 * @package ApiBundle\Requests\Tournament
 */
class JoinTournamentRequest extends ApiRequestBase {

    /**
     * @Assert\NotBlank(message="error.generic.not_blank")
     * @Assert\GreaterThan(0, message="error.generic.greater_then")
     * @Api\RequestMap("tournamentId")
     * @Api\EntityId
     */
    public $tournamentId;

    /**
     * @Assert\NotBlank(message="error.generic.not_blank")
     * @Assert\Regex("/^P[1-9][0-9]{0,}/")
     * @Api\RequestMap("playerId")
     */
    public $playerId;

    /**
     * @Api\RequestMap("backerId", queryBadPractice=true)
     */
    public $backerIds = [];

}