<?php

namespace ApiBundle\Requests\Tournament;

use ApiBundle\ApiResources\RequestFactory\ApiRequestBase;
use Symfony\Component\Validator\Constraints as Assert;
use ApiBundle\Annotations\API;

/**
 * Class ResultTournamentRequest
 * @package ApiBundle\Requests\Tournament
 */
class ResultTournamentRequest extends ApiRequestBase {

    /**
     * @Assert\NotBlank(message="error.generic.not_blank")
     * @Assert\GreaterThan(0, message="error.generic.greater_then")
     * @Api\RequestMap("tournamentId")
     * @Api\EntityId
     */
    public $tournamentId;

    /**
     * @Api\RequestMap("winners")
     */
    public $winners = [];
}