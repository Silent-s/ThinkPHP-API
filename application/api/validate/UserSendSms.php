<?php

namespace app\api\validate;

/**
 * 发送短信相关验证
 * Class UserSendSms
 * @package app\api\validate
 */
class UserSendSms extends BaseValidate
{
    protected $rule = [
        'mobile_number' => 'require|isMobile',
    ];

    protected $message = [
        'mobile_number.require' => '手机号码不能为空',
        'mobile_number.isMobile' => '手机号码格式不正确',
    ];

}