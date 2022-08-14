<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{

    public function __construct()
    {
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getThrowable();
        // Get incoming request
        $request   = $event->getRequest();

        // Check if it is a rest api request
        if ('application/json' === $request->headers->get('Content-Type'))
        {

            // Customize your response object to display the exception details
            $response = new JsonResponse([
                'message'       => $exception->getMessage(),
                'code'          => $exception->getCode(),
            ]);

            // HttpExceptionInterface is a special type of exception that
            // holds status code and header details
            if ($exception instanceof HttpExceptionInterface) {
                $response->setStatusCode($exception->getStatusCode());
                $response->headers->replace($exception->getHeaders());
            } else {
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            // sends the modified response object to the event
            $event->setResponse($response);
        }
    }
}
