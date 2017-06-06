<?php

namespace ApiBundle\ApiResources\RequestFactory;

/**
 * Class ApiRequestBase
 * @package ApiBundle\ApiResources\RequestFactory
 */
abstract class ApiRequestBase {

    /**
     * @var string
     */
    protected $idField;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->hasIdField() ? $this->{$this->idField} : null;
    }

    /**
     * @param string $idField
     * @return $this
     */
    public function setIdField($idField) {
        $this->idField = $idField;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdField() {
        return $this->idField;
    }

    /**
     * @return bool
     */
    public function hasIdField() {
        return !empty($this->idField);
    }

}