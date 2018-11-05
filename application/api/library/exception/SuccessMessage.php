<?php

namespace app\lib\exception;

use app\api\library\exception\BaseException;

/**
 * 成功统一处理
 */
class SuccessMessage extends BaseException
{
    public $code = 201;
    public $msg = 'ok';
    public $errorCode = 0;
}