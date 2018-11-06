<?php

namespace app\api\validate;

/**
 * 会员登录相关验证
 */
class UserLogin extends BaseValidate
{
    protected $rule = [
        'telphone'  => 'require|isMobile',
        'password' => 'require|length:1,20',
    ];

    protected $message = [
        'telphone.require'  => '手机号不能为空',
        'telphone.isMobile' => '手机号格式不正确',
        'password.require' => '密码不能为空',
        'password.length'  => '密码在6-20个字符之间'
    ];
}