<?php

namespace app\api\library\exception;

class ForbiddenException extends BaseException
{
    public $httpCode = 403;
    public $errorCode = 20007;
    public $msg = "权限不足,请勿继续尝试";
}