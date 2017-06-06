<?php

namespace ApiBundle\ApiResources\ResponseBuilder;

use ApiBundle\ApiResources\ControllerBuilder\ApiControllerBuilder;
use ApiBundle\ApiResources\RequestFactory\RequestResolverInterface;
use ApiBundle\Exceptions\ApiBaseException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class ApiResponseBuilder
 * @package ApiBundle\ApiResources\ResponseBuilder
 */
class ApiResponseBuilder {

    private $response;

    private $requestResolver;

    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * @var ApiResponseFactory
     */
    private $responseFactory;
    /**
     * @var ApiControllerBuilder
     */
    private $controllerBuilder;

    public function __construct(
        ApiResponseFactory $responseFactory,
        RequestResolverInterface $requestResolver,
        TranslatorInterface $translator,
        ApiControllerBuilder $controllerBuilder
    ) {
        $this->response = $responseFactory->getResponse();
        $this->requestResolver = $requestResolver;
        $this->translator = $translator;
        $this->responseFactory = $responseFactory;
        $this->controllerBuilder = $controllerBuilder;
    }

    /**
     * @return mixed
     */
    public function createResponse() {
        switch ($this->requestResolver->getContentType()) {
            case 'application/json':
                return new JsonResponse($this->response->body, $this->response->statusCode, $this->response->headers);
            default:
                $this->requestResolver->throwUnsupportedContentType();
        }
    }

    public function createErrorResponse($exception, callable $setResponse) {
        if($exception instanceof \LogicException) {
            $this->controllerBuilder->postControllerHock();
            call_user_func($setResponse, $this->createResponse());
        } elseif ($exception instanceof ApiBaseException) {
            $errorMsg = $this->translator->trans($exception->messageKey, $exception->messageParameters);
            $this->responseFactory->set('error', $errorMsg);
            $this->responseFactory->set('error_code', $exception->getCode());
            $this->responseFactory->setStatusCode($exception->getCode());
            call_user_func($setResponse, $this->createResponse());
        }
    }

}