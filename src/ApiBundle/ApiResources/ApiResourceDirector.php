<?php

namespace ApiBundle\ApiResources;

use ApiBundle\Annotations\API\RequestMap;
use ApiBundle\ApiResources\ControllerBuilder\ExposedContainer;
use ApiBundle\ApiResources\RequestFactory\ApiRequestBase;
use ApiBundle\ApiResources\RequestFactory\ApiRequestFactory;
use ApiBundle\ApiResources\ResourceBuilder\ResourceBuilderBase;
use ApiBundle\ApiResources\ResponseBuilder\ApiResponseFactory;
use ApiBundle\Exceptions\NotFoundException;
use ApiBundle\Exceptions\UnprocessableEntityException;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ApiResourceDirector
 * @package ApiBundle\ApiResources
 */
class ApiResourceDirector {

    /**
     * @var ApiRequestFactory
     */
    private $requestFactory;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var AnnotationReader
     */
    private $annotationReader;

    /**
     * @var ApiResponseFactory
     */
    private $responseFactory;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var ApiRequestBase|null
     */
    private $request = null;

    /**
     * @var ResourceBuilderBase|null
     */
    private $resource = null;

    /**
     * @var object|null
     */
    private $entity = null;

    /**
     * @var ExposedContainer
     */
    private $exposedContainer;

    /**
     * ApiResourceDirector constructor.
     * @param ApiRequestFactory $requestFactory
     * @param ValidatorInterface $validator
     * @param ApiResponseFactory $responseFactory
     * @param EntityManager $entityManager
     * @param ExposedContainer $exposedContainer
     */
    public function __construct(
        ApiRequestFactory $requestFactory,
        ValidatorInterface $validator,
        ApiResponseFactory $responseFactory,
        EntityManager $entityManager,
        ExposedContainer $exposedContainer
    ) {
        $this->requestFactory = $requestFactory;
        $this->validator = $validator;
        $this->responseFactory = $responseFactory;
        $this->annotationReader = new AnnotationReader();
        $this->entityManager = $entityManager;
        $this->exposedContainer = $exposedContainer;
    }

    public function process(ResourceBuilderBase $resource) {
        $this->resource = $resource;
        $this->request = $this->requestFactory->createRequest($this->resource->getRequest());
        $this->validateRequest();
        $this->getResourceEntity();
        $this->exposedContainer->expose($this->request)->expose($this->responseFactory);
    }

    private function validateRequest() {
        $validationErrors = $this->validator->validate($this->request);
        /** @var ConstraintViolation $error */
        foreach ($validationErrors as $error) {
            $propertyReflection = new \ReflectionProperty($this->request, $error->getPropertyPath());
            $map = $this->annotationReader->getPropertyAnnotation($propertyReflection, RequestMap::class);
            if($map instanceof RequestMap) {
                $this->responseFactory->add("meta.validation.{$map->value}", $error->getMessage());
            }
        }
        if(count($validationErrors) > 0) {
            throw new UnprocessableEntityException('validation.error');
        }
    }

    private function getResourceEntity() {
        $repo = $this->entityManager->getRepository($this->resource->getEntity());
        $this->entity = $this->resource->resolveEntity($repo, $this->request);
        if(!$this->entity) {
            throw new NotFoundException('exception.entity.not_found', [
                'entity_namespace' => $this->resource->getEntity(),
                'entity_id' => $this->request->getId()
            ]);
        }
        $this->exposedContainer->expose($this->entity);
    }

}