<?php

namespace Dameert\FrontendCms\Exception;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InvalidDataException extends NotFoundHttpException
{
    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        if (!$message) {
            $message = "Loaded data is invalid.";
        }
        parent::__construct($message, $previous, $code);
    }
}