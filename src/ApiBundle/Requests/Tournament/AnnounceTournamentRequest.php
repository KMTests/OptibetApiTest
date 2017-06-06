<?php

namespace ApiBundle\Requests\Tournament;

use ApiBundle\ApiResources\RequestFactory\ApiRequestBase;
use Symfony\Component\Validator\Constraints as Assert;
use ApiBundle\Annotations\API;

/**
 * Class AnnounceTournamentRequest
 * @package ApiBundle\Requests\Tournament
 */
class AnnounceTournamentRequest extends ApiRequestBase {

    /**
     * @Assert\NotBlank(message="error.generic.not_blank")
     * @Assert\GreaterThan(0, message="error.generic.greater_then")
     * @Api\RequestMap("tournamentId")
     * @Api\EntityId
     */
    public $tournamentId;

    /**
     * @Assert\NotBlank(message="error.generic.not_blank")
     * @Assert\GreaterThan(0, message="error.generic.greater_then")
     * @Api\RequestMap("deposit")
     */
    public $deposit;

}