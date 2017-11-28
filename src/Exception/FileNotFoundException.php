<?php

namespace Dameert\FrontendCms\Exception;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FileNotFoundException extends NotFoundHttpException
{
    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        if (!$message) {
            $message = "File not found.";
        }
        parent::__construct($message, $previous, $code);
    }
}