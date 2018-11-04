<?php

namespace app\api\library\exception;

use Exception;
use think\db\exception\ModelNotFoundException;
use think\exception\Handle;
use think\facade\Log;
use think\facade\Request;

class ExceptionHandler extends Handle
{
    private $httpCode;    // http状态码
    private $msg;         // 提示信息
    private $errorCode;   // 状态码

    /**
     * 异常错误统一处理
     * @param Exception $e
     * @return \think\Response|\think\response\Json
     */
    public function render(Exception $e)
    {

        if ($e instanceof BaseException) {
            // 拦截自定义异常错误处理
            $this->setResponseContent($e->httpCode, $e->msg, $e->errorCode);
        } else if ($e instanceof \UnexpectedValueException) {
            // 拦截token异常抛出的错误
            $this->setResponseContent(401, $e->getMessage(), 700);
        } else if ($e instanceof ModelNotFoundException) {
            // 模型找不到数据时抛出异常
            $this->setResponseContent(404, $e->getMessage(), 800);
        } else {
            if (config('app_debug')) {
                // 调试模式记录, 展示具体信息
                return parent::render($e);
            } else {
                $this->setRecordErrorLogs($e);
                $this->setResponseContent(500, '服务器内部异常', $e->getMessage(), 900);
            }
        }
        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'request_url' => Request::url(true),
        ];
        return json($result, $this->httpCode);
    }


    /**
     * 设置响应内容
     * @param $httpCode
     * @param $msg
     * @param $errorCode
     */
    private function setResponseContent($httpCode, $msg, $errorCode)
    {
        $this->httpCode = $httpCode;
        $this->msg = $msg;
        $this->errorCode = $errorCode;
    }

    /**
     * 记录服务器异常
     * @param $e
     */
    private function setRecordErrorLogs($e)
    {
        // 初始化日志(默认日志系统已经关闭)
        Log::init([
            // 日志记录方式，支持 file socket 或者自定义驱动类
            'type' => 'File',
            //日志保存目录
            'path' => '../api/logs/',
            //单个日志文件的大小限制，超过后会自动记录到第二个文件
            'file_size' => 2097152,
            //日志的时间格式，默认是` c `
            'time_format' => 'c'
        ]);
        Log::record($e->getMessage(), 'error');
    }

}