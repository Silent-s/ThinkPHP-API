<?php

namespace app\api\library\exception;

use Exception;
use think\exception\Handle;
use think\facade\Log;
use think\facade\Request;

class ExceptionHandler extends Handle
{
    private $httpCode;    // http状态码
    private $msg;         // 提示信息
    private $errorCode;   // 状态码

    /**
     * 统一异常处理
     * @param Exception $e
     * @return \think\Response|\think\response\Json
     */
    public function render(Exception $e)
    {
        // 两种异常:1.自定义错误异常 2.系统错误异常
        if ($e instanceof BaseException) {
            // 自定义错误异常
            $this->httpCode = $e->httpCode;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        } else {
            // 系统异常,开发时需要看见具体错误信息
            // 生产时,需要给客户端返回统一信息
            if (config('app_debug')) {
                // 默认异常页面
                return parent::render($e);
            } else {
                // 统一状态信息
                $this->code = 500;
                $this->msg = '服务器内部异常';
                $this->errorCode = 999;
                // 记录日志,方便开发查看
                $this->recordErrorLog($e);
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
     * 记录服务器异常
     * @param $e
     */
    private function recordErrorLog($e)
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