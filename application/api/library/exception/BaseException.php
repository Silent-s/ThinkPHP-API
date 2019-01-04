<?php

namespace app\api\library\exception;

use Exception;

class BaseException extends Exception
{
    public $httpCode = 400;     // Http状态码
    public $msg = '参数错误';    // 错误描述信息
    public $errorCode = 10000;  // 自定义错误码

    /**
     * 初始化操作
     * BaseException constructor.
     * @param array $params
     */
    public function __construct($params = [])
    {
        if (!is_array($params)) {
            // 对当前属性不做任何修改
            return;
        }
        if (array_key_exists('httpCode', $params)) {
            $this->httpCode = $params['httpCode'];
        }
        if (array_key_exists('msg', $params)) {
            $this->msg = $params['msg'];
        }
        if (array_key_exists('errorCode', $params)) {
            $this->errorCode = $params['errorCode'];
        }
    }
}