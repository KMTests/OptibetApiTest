<?php

namespace ApiBundle\ApiResources\RequestFactory;

use ApiBundle\Exceptions\NotImplementedException;

/**
 * Interface RequestResolverInterface
 * @package ApiBundle\ApiResources\RequestFactory
 */
interface RequestResolverInterface {

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default);

    /**
     * @param string $key
     * @return bool
     */
    public function has($key);

    /**
     * @return array
     */
    public function getAll();

    /**
     * @return string
     */
    public function getContentType();

    /**
     * @throws NotImplementedException
     */
    public function throwUnsupportedContentType();

}