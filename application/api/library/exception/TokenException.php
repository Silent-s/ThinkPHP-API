<?php

namespace app\api\library\exception;

class TokenException extends BaseException
{
    public $httpCode = 401;
    public $errorCode = 20003;
    public $msg = "Token已过期或无效Token'";
}