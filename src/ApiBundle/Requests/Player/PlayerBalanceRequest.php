<?php

namespace ApiBundle\Requests\Player;

use ApiBundle\ApiResources\RequestFactory\ApiRequestBase;
use Symfony\Component\Validator\Constraints as Assert;
use ApiBundle\Annotations\API;

/**
 * Class PlayerBalanceRequest
 * @package ApiBundle\Requests\Player
 */
class PlayerBalanceRequest extends ApiRequestBase {

    /**
     * @Assert\NotBlank(message="error.generic.not_blank")
     * @Assert\Regex("/^P[1-9][0-9]{0,}/")
     * @Api\RequestMap("playerId")
     * @Api\EntityId
     */
    public $playerId;

}