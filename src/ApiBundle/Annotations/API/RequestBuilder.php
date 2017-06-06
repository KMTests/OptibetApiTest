<?php

namespace ApiBundle\Annotations\API;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class RequestBuilder
 * @package ApiBundle\Annotations\API
 * @Annotation
 * @Target({"METHOD"})
 */
class RequestBuilder {

    const REQUEST_NAMESPACE_BASE = 'ApiBundle\ResourceBuilders';

    /**
     * @var string
     */
    public $value = null;

    /**
     * @var bool
     */
    public $service = false;

    /**
     * @return string
     */
    public function getRequestBuilder() {
        return $this->isService() ? $this->value : self::REQUEST_NAMESPACE_BASE . '\\' . $this->value;
    }

    /**
     * @return bool
     */
    public function isService() {
        return $this->service;
    }

}