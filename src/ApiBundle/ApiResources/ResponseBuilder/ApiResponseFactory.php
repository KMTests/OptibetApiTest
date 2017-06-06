<?php

namespace ApiBundle\ApiResources\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ApiResponseFactory
 * @package ApiBundle\ApiResources\ResponseBuilder
 */
class ApiResponseFactory {

    const MODE_APPEND = 'APPEND';
    const MODE_SET = 'SET';
    const DELIMITER = '.';

    /**
     * @var ApiResponse
     */
    private $response;

    /**
     * ApiResponseFactory constructor.
     */
    public function __construct() {
        $this->clear();
    }

    /**
     * @return $this
     */
    public function clear() {
        $this->response = new ApiResponse();
        return $this;
    }

    /**
     * @param ApiResponse $response
     * @return $this
     */
    public function setResponse(ApiResponse $response) {
        $this->response = $response;
        return $this;
    }

    public function setStatusCode($statusCode) {
        $this->response->statusCode = $statusCode;
        return $this;
    }

    public function setHeader($name, $value) {
        $this->response->headers[$name] = $value;
        return $this;
    }

    /**
     * @return ApiResponse
     */
    public function getResponse() {
        return $this->response;
    }

    /**
     * @param string $key
     * @param mixed $data
     * @return $this
     */
    public function set($key, $data) {
        $this->setKey($key, $data, $this->response->body, self::MODE_SET);
        return $this;
    }

    /**
     * @param string $key
     * @param mixed $data
     * @return $this
     */
    public function add($key, $data) {
        $this->setKey($key, $data, $this->response->body, self::MODE_APPEND);
        return $this;
    }

    /**
     * @param string $key
     * @param mixed $data
     * @param array $response
     * @param string $mode
     * @return array|mixed
     */
    private function setKey($key, $data, array &$response, $mode = self::MODE_SET) {
        $keys = $this->getKeys($key);
        while(count($keys) > 1) {
            $key = $this->createArrayIfNotSet($response, $keys);
            $response = &$response[$key];
        }
        if($mode === self::MODE_SET) {
            $response[array_shift($keys)] = $data;
        } elseif ($mode == self::MODE_APPEND) {
            $key = $this->createArrayIfNotSet($response, $keys);
            $response[$key][] = $data;
        }
        return $response;
    }

    /**
     * @param string $key
     * @return array
     */
    private function getKeys($key) {
        return explode(self::DELIMITER, $key);
    }

    /**
     * @param array $array
     * @param array $keys
     * @return mixed
     */
    private function createArrayIfNotSet(&$array, &$keys) {
        $key = array_shift($keys);
        if (!isset($array[$key]) || !is_array($array[$key])) {
            $array[$key] = [];
        }
        return $key;
    }
}