<?php

namespace ApiBundle\ApiResources\ControllerBuilder;

use ApiBundle\Annotations\API\RequestBuilder;
use ApiBundle\ApiResources\ApiResourceDirector;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiControllerBuilder
 * @package ApiBundle\ApiResources\ControllerBuilder
 */
class ApiControllerBuilder {

    /**
     * @var ExposedContainer
     */
    private $exposedContainer;

    /**
     * @var AnnotationReader
     */
    private $annotationReader;

    /**
     * @var array
     */
    private $controller;

    /**
     * @var ApiResourceDirector
     */
    private $resourceDirector;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * ApiControllerBuilder constructor.
     * @param ExposedContainer $exposedContainer
     * @param ApiResourceDirector $resourceDirector
     * @param ContainerInterface $container
     * @param EntityManager $entityManager
     */
    public function __construct(
        ExposedContainer $exposedContainer,
        ApiResourceDirector $resourceDirector,
        ContainerInterface $container,
        EntityManager $entityManager
    ) {
        $this->exposedContainer = $exposedContainer;
        $this->annotationReader = new AnnotationReader();
        $this->resourceDirector = $resourceDirector;
        $this->container = $container;
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $controller
     * @return $this
     */
    public function setController(array $controller) {
        $this->controller = $controller;
        return $this;
    }

    public function preControllerHock() {
        $builderAnnotation = $this->annotationReader->getMethodAnnotation(
            $this->createControllerAnnotation(),
            RequestBuilder::class
        );
        if($builderAnnotation instanceof RequestBuilder) {
            $builder = $builderAnnotation->getRequestBuilder();
            if($builderAnnotation->isService()) {
                $this->resourceDirector->process($this->container->get($builder));
            } else {
                $this->resourceDirector->process(new $builder());
            }
        }
    }

    /**
     * @param Request $request
     */
    public function resolveControllerArguments(Request $request) {
        foreach ($this->createControllerAnnotation()->getParameters() as $parameter) {
            $namespace = $parameter->getClass()->getName();
            if($this->exposedContainer->has($namespace)) {
                $request->attributes->set($parameter->getName(), $this->exposedContainer->get($namespace));
            }
        }
    }

    /**
     * @return \ReflectionMethod
     */
    private function createControllerAnnotation() {
        return new \ReflectionMethod($this->controller[0], $this->controller[1]);
    }

    public function postControllerHock() {
        $this->entityManager->flush();
        return $this;
    }

}