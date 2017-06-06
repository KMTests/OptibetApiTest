<?php

namespace ApiBundle\ResourceBuilders\Tournament;

use ApiBundle\ApiResources\ResourceBuilder\ResourceBuilderBase;
use ApiBundle\Entity\Tournament;
use ApiBundle\Requests\Tournament\JoinTournamentRequest;

/**
 * Class JoinTournamentResource
 * @package ApiBundle\ResourceBuilders\Tournament
 */
class JoinTournamentResource extends ResourceBuilderBase {

    protected $request = JoinTournamentRequest::class;
    protected $entity = Tournament::class;

}