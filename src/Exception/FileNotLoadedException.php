<?php

namespace Dameert\FrontendCms\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FileNotLoadedException extends NotFoundHttpException
{
    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        if (!$message) {
            $message = "Unable to load the datasource.";
        }
        parent::__construct($message, $previous, $code);
    }
}