<?php

namespace ApiBundle\ResourceBuilders\Player;

use ApiBundle\ApiResources\ResourceBuilder\ResourceBuilderBase;
use ApiBundle\Entity\Player;
use ApiBundle\Requests\Player\PlayerBalanceRequest;

/**
 * Class PlayerBalanceResource
 * @package ApiBundle\ResourceBuilders\Player
 */
class PlayerBalanceResource extends ResourceBuilderBase {

    use PlayerEntityTrait;

    protected $request = PlayerBalanceRequest::class;
    protected $entity = Player::class;

}