<?php

namespace App\EventListener;

use App\Exception\BilemoException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use TypeError;
use Webmozart\Assert\InvalidArgumentException;

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
        $request = $event->getRequest();
        // Customize your response object to display the exception details
        $response = new JsonResponse();

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->setData([
                "code" => $exception->getStatusCode(),
                "message" => $exception->getMessage(),
            ]);
            $response->headers->replace($exception->getHeaders());
        } elseif ($exception instanceof BilemoException) {
            $response->setStatusCode($exception->getCode());
            $response->setData([
                "code" => $exception->getCode(),
                "message" => $exception->getMessage(),
            ]);
        } elseif ($exception instanceof TypeError || $exception instanceof InvalidArgumentException) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setData([
                "code" => Response::HTTP_BAD_REQUEST,
                "message" => "Error with your parameters, please verify them !",
            ]);
        } else {
            $response->setData([
                "code" => Response::HTTP_INTERNAL_SERVER_ERROR,
                "message" => "Internal error",
            ]);
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $response->setEncodingOptions( $response->getEncodingOptions() | JSON_PRETTY_PRINT );
        // sends the modified response object to the event
        $event->setResponse($response);
    }
}
