<?php

namespace ApiBundle\ResourceBuilders\Tournament;

use ApiBundle\ApiResources\ResourceBuilder\ResourceBuilderBase;
use ApiBundle\Entity\Tournament;
use ApiBundle\Requests\Tournament\ResultTournamentRequest;

/**
 * Class ResultTournamentResource
 * @package ApiBundle\ResourceBuilders\Tournament
 */
class ResultTournamentResource extends ResourceBuilderBase {

    protected $request = ResultTournamentRequest::class;
    protected $entity = Tournament::class;

}