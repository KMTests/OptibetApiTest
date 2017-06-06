<?php

namespace ApiBundle\Requests\Player;

use ApiBundle\ApiResources\RequestFactory\ApiRequestBase;
use Symfony\Component\Validator\Constraints as Assert;
use ApiBundle\Annotations\API;

/**
 * Class FundPointsRequest
 * @package ApiBundle\Requests\Player
 */
class FundPointsRequest extends ApiRequestBase {

    /**
     * @Assert\NotBlank(message="error.generic.not_blank")
     * @Assert\GreaterThan(0, message="error.generic.greater_then")
     * @Api\RequestMap("points")
     */
    public $amount;

    /**
     * @Assert\NotBlank(message="error.generic.not_blank")
     * @Assert\Regex("/^P[1-9][0-9]{0,}/")
     * @Api\RequestMap("playerId")
     * @Api\EntityId
     */
    public $playerId;

}