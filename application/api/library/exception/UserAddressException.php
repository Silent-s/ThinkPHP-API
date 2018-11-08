<?php

namespace app\api\library\exception;

class UserAddressException extends BaseException
{
    public $httpCode = 400;
    public $errorCode = 30000;
    public $msg = "用户收货地址不存在";
}