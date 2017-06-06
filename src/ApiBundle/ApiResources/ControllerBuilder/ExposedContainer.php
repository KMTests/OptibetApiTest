<?php

namespace ApiBundle\ApiResources\ControllerBuilder;

/**
 * Class ExposedContainer
 * @package ApiBundle\ApiResources\ControllerBuilder
 */
class ExposedContainer {

    /**
     * @var array
     */
    private $container = [];

    /**
     * @param object $object
     * @return $this
     */
    public function expose($object) {
        $this->container[get_class($object)] = $object;
        return $this;
    }

    /**
     * @param string $namespace
     * @return mixed
     */
    public function get($namespace) {
        return $this->has($namespace) ? $this->container[$namespace] : null;
    }

    /**
     * @param mixed $namespace
     * @return bool
     */
    public function has($namespace) {
        return array_key_exists($namespace, $this->container);
    }
}