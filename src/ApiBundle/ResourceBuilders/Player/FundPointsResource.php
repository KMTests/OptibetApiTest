<?php

namespace ApiBundle\ResourceBuilders\Player;

use ApiBundle\ApiResources\ResourceBuilder\ResourceBuilderBase;
use ApiBundle\Entity\Player;
use ApiBundle\Requests\Player\FundPointsRequest;

/**
 * Class FundPointsResource
 * @package ApiBundle\ResourceBuilders\Player
 */
class FundPointsResource extends ResourceBuilderBase {

    use PlayerEntityTrait;

    protected $request = FundPointsRequest::class;
    protected $entity = Player::class;

}