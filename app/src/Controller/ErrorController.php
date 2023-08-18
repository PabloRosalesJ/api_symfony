<?php

namespace Crimsoncircle\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
// use Symfony\Component\HttpFoundation\Response;
use Crimsoncircle\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ErrorController
{
    public function exception(\Throwable $exception): JsonResponse
    {
        // $msg = 'Something went wrong! ('.$exception->getMessage().')';
        // dd($exception);

        $message = $exception->getMessage();
        $code = $exception->getCode();

        if ($exception instanceof ModelNotFoundException) {
            $id = $exception->getIds()[0];
            $message = sprintf("The resource %s don't exists", $id);
            $code = 404;
        }

        if ($exception instanceof QueryException) {
            $err = $exception->getPrevious();
            $message = $err->getMessage();
            $code = 400;
        }

        return Response::error($message, $code);
    }
}