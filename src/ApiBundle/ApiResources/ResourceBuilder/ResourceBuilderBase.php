<?php

namespace ApiBundle\ApiResources\ResourceBuilder;

use ApiBundle\ApiResources\RequestFactory\ApiRequestBase;
use ApiBundle\Exceptions\InternalServerException;
use Doctrine\ORM\EntityRepository;

/**
 * Class ResourceBuilderBase
 * @package ApiBundle\ApiResources\ResourceBuilder
 */
abstract class ResourceBuilderBase {

    protected $request;
    protected $entity;

    public function getRequest() {
        return $this->request;
    }

    public function getEntity() {
        return $this->entity;
    }

    public function resolveEntity(EntityRepository $repo, ApiRequestBase $request) {
        return $repo->find($request->getId());
    }

}