<?php

namespace ApiBundle\Annotations\API;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class RequestMap
 * @package ApiBundle\Annotations\API
 * @Annotation
 * @Target({"PROPERTY"})
 */
class RequestMap {

    public $value;

    public $default = null;

    public $queryBadPractice = false;

}