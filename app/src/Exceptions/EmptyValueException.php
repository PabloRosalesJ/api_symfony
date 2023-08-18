<?php
declare(strict_types=1);
namespace Crimsoncircle\Exceptions;

class EmptyValueException extends \Exception {
    public function __construct(
        $message,
        $code = 0,
        \Throwable $previous = null
    )
    {
        // dd($code);
        parent::__construct(
            sprintf('El campo %s no puede ser un string vacío.', $message),
            $code,
            $previous
        );
    }
}