<?php

namespace app\api\library\exception;

class UserException extends BaseException
{
    public $httpCode = 404;
    public $errorCode = 20000;
    public $msg = "用户不存在";
}