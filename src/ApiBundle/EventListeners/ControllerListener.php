<?php

namespace ApiBundle\EventListeners;

use ApiBundle\ApiResources\ApiResourceDirector;
use ApiBundle\ApiResources\ControllerBuilder\ApiControllerBuilder;
use ApiBundle\ApiResources\ResponseBuilder\ApiResponseBuilder;
use ApiBundle\ApiResources\ResponseBuilder\ApiResponseFactory;
use ApiBundle\Exceptions\ApiBaseException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class ControllerListener
 * @package ApiBundle\EventListeners
 */
class ControllerListener {


    /**
     * @var ApiResponseBuilder
     */
    private $responseBuilder;
    /**
     * @var ApiControllerBuilder
     */
    private $controllerBuilder;

    public function __construct(
        ApiResponseBuilder $responseBuilder,
        ApiControllerBuilder $controllerBuilder
    ) {
        $this->responseBuilder = $responseBuilder;
        $this->controllerBuilder = $controllerBuilder;
    }

    public function onKernelController(FilterControllerEvent $event) {
        $this->controllerBuilder->setController($event->getController())->preControllerHock();
        $this->controllerBuilder->resolveControllerArguments($event->getRequest());
    }

    public function onKernelException(GetResponseForExceptionEvent $event) {
        $event->allowCustomResponseCode();
        $this->responseBuilder->createErrorResponse($event->getException(), [$event, 'setResponse']);
    }

}