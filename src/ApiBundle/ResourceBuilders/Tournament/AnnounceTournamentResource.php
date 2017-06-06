<?php

namespace ApiBundle\ResourceBuilders\Tournament;

use ApiBundle\ApiResources\ResourceBuilder\ResourceBuilderBase;
use ApiBundle\Entity\Tournament;
use ApiBundle\Requests\Tournament\AnnounceTournamentRequest;

class AnnounceTournamentResource extends ResourceBuilderBase {

    protected $request = AnnounceTournamentRequest::class;
    protected $entity = Tournament::class;

}