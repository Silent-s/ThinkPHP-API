<?php

namespace app\api\controller\v1;

use think\Controller;
use app\api\service\Sms as SmsService;
use app\api\validate\UserSendSms as UserSendSmsValidate;

class Sms extends Controller
{
    /**
     * 发送短信
     *
     * @method    POST
     * @url       /api/v1/sms
     * @param     mobile_number  手机号
     * @param     event          发送事件
     */
    public function store()
    {
        (new UserSendSmsValidate())->checkParams();

        $mobile_number = $this->request->post('mobile_number');
        $event = $this->request->post('event');
        $event = $event ? $event : 'register';
        SmsService::send($mobile_number, $event);
    }
}