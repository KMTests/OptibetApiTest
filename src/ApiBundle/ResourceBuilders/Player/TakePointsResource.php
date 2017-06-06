<?php

namespace ApiBundle\ResourceBuilders\Player;

use ApiBundle\ApiResources\ResourceBuilder\ResourceBuilderBase;
use ApiBundle\Entity\Player;
use ApiBundle\Requests\Player\TakePointsRequest;

/**
 * Class TakePointsResource
 * @package ApiBundle\ResourceBuilders\Player
 */
class TakePointsResource extends ResourceBuilderBase {

    use PlayerEntityTrait;

    protected $request = TakePointsRequest::class;
    protected $entity = Player::class;

}