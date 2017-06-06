<?php

namespace ApiBundle\ApiResources\RequestFactory;

use ApiBundle\Annotations\API\EntityId;
use ApiBundle\Annotations\API\RequestMap;
use Doctrine\Common\Annotations\AnnotationReader;

/**
 * Class ApiRequestFactory
 * @package ApiBundle\ApiResources\RequestFactory
 */
class ApiRequestFactory {

    /**
     * @var RequestResolverInterface
     */
    private $requestResolver;

    /**
     * @var AnnotationReader
     */
    private $annotationReader;

    /**
     * ApiRequestFactory constructor.
     * @param RequestResolverInterface $requestResolver
     */
    public function __construct(RequestResolverInterface $requestResolver) {
        $this->requestResolver = $requestResolver;
        $this->annotationReader = new AnnotationReader();
    }

    /**
     * @param $requestNamespace
     * @return ApiRequestBase
     */
    public function createRequest($requestNamespace) {
        $requestReflection = new \ReflectionClass($requestNamespace);
        $request = $requestReflection->newInstance();
        foreach ($requestReflection->getProperties() as $property) {
            $this->mapRequestProperties($property, $request);
            $this->checkForId($property, $request);
        }
        return $this->ensureRequestExtendsBase($request);
    }

    /**
     * @param \ReflectionProperty $property
     * @param $request
     */
    private function mapRequestProperties(\ReflectionProperty $property, $request) {
        $map = $this->annotationReader->getPropertyAnnotation($property, RequestMap::class);
        if($map instanceof RequestMap) {
            if(!$map->queryBadPractice) {
                $request->{$property->getName()} = $this->requestResolver->get($map->value, $map->default);
            } else {
                $queryItems = explode('&', $_SERVER['QUERY_STRING']);
                foreach ($queryItems as $item) {
                    $values = explode('=', $item);
                    if($values[0] == $map->value) {
                        $request->{$property->getName()}[] = $values[1];
                    }
                }
            }
        }
    }

    /**
     * @param \ReflectionProperty $property
     * @param $request
     */
    private function checkForId(\ReflectionProperty $property, $request) {
        $isId = $this->annotationReader->getPropertyAnnotation($property, EntityId::class);
        if($isId instanceof EntityId && $request instanceof ApiRequestBase) {
            $request->setIdField($property->getName());
        }
    }

    /**
     * @param ApiRequestBase $request
     * @return ApiRequestBase
     */
    private function ensureRequestExtendsBase(ApiRequestBase $request) {
        return $request;
    }

}