<?php

namespace ApiBundle\ResourceBuilders\Player;

use ApiBundle\ApiResources\RequestFactory\ApiRequestBase;
use ApiBundle\Entity\Player;
use Doctrine\ORM\EntityRepository;

/**
 * Class PlayerEntityTrait
 * @package ApiBundle\ResourceBuilders\Player
 */
trait PlayerEntityTrait {

    /**
     * @param EntityRepository $repo
     * @param ApiRequestBase $request
     * @return null|object
     */
    public function resolveEntity(EntityRepository $repo, ApiRequestBase $request) {
        return $repo->find(substr($request->getId(), 1));
    }

}