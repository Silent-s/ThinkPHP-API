<?php

namespace app\api\service;

use app\api\library\exception\UserException;
use app\api\model\Sms as SmsModel;
use app\api\model\User as UserModel;
use Shoudian\AliSms\Lite;
use think\facade\Request;

class Sms
{
    protected $expire;
    protected $signName;
    protected $accessKeyId;
    protected $accessSecret;

    public function __construct()
    {
        $this->expire = config('sms.expire');
        $this->signName = config('sms.sign_name');
        $this->accessKeyId = config('sms.access_key_id');
        $this->accessSecret = config('sms.access_secret');
    }

    public function send($mobile_number, $event)
    {
        $last = SmsModel::getLastTime($mobile_number, $event);
        if ($last && time() - $last['create_time']) {
            throw new UserException([
                'httpCode' => '',
                'msg' => '短信发送频繁',
            ]);
        }
        $ipSendTotal = SmsModel::getIpsendTotal(Request::ip());
        if ($ipSendTotal >= 5) {
            throw new UserException([
                'httpCode' => '',
                'msg' => '短信发送频繁',
            ]);
        }
        if ($event) {
            $userinfo = UserModel::getByMobileNumber($mobile_number);
            if ($event === 'register' && $userinfo) {
                throw new UserException([
                    'httpCode' => '',
                    'msg' => '手机号已被注册',
                ]);
            }
        }
        // 发送短信(阿里大于短信系统)
        $this->sendSms($mobile_number);
    }


    public function sendSms($mobile_number)
    {
        $code = mt_rand(1000, 9999);
        $params = [
            'accessKeyId' => $this->accessKeyId,
            'accessKeySecret' => $this->accessSecret,
            'SignName' => $this->signName,
            'charset' => 'UTF-8'
        ];
        $alisms = new Lite();
        $alisms->sendSms($params,$mobile_number);
    }
}