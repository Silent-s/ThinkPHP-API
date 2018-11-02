<?php

namespace app\api\library\exception;

class ParameterException extends BaseException
{
    public $httpCode = 400;
    public $errorCode = 10000;
    public $msg = "参数错误";
}