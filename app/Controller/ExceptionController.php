<?php namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Debug\Exception\FlattenException;

/**
 * Handles FlattenExceptions generated by the ExceptionListener subscriber.
 */
class ExceptionController
{
    /**
     * @param FlattenException exception
     *
     * @return Response|FlattenException
     */
    public function handle(FlattenException $exception)
    {
        if ($exception->getStatusCode() === 404) {
            return new Response('Not found', 404);
        }

        return $exception;
    }
}
