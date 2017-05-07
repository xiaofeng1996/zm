<?php

namespace app\Services\Code;

class CodeException extends \Exception
{
    protected $statusCode = 500;

    public function __construct($message, $statusCode = null)
    {
        parent::__construct($message);
        if (!is_null($statusCode)) {
            $this->setStatusCode($statusCode);
        }
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}