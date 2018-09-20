<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    private $debug;

    private $errorMessages = [
        'defaultErrorMessage' => 'Something went wrong',
    ];

    public function __construct(bool $debug)
    {
        $this->debug = $debug;
    }

    public function processException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if ($this->debug) {
            $this->errorMessages['defaultErrorMessage'] = $exception->getMessage();
        }

        $response = new JsonResponse($this->errorMessages);

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [
                'processException',
            ],
        ];
    }
}
