<?php

namespace app\api\validate;

/**
 * 会员注册相关验证
 * Class UserRegister
 * @package app\api\validate
 */
class UserRegister extends BaseValidate
{
    protected $rule = [
        'mobile_number' => 'require|isMobile',
        'verify_code' => 'require|integer|length:6',
        'nickname' => 'require|length:4,16',
        'password' => 'require|length:6,20',
    ];

    protected $message = [
        'mobile_number.require' => '手机号码不能为空',
        'mobile_number.isMobile' => '手机号码格式不正确',
        'verify_code.require' => '验证码不能为空',
        'verify_code.integer' => '验证码必须是6位纯数字',
        'verify_code.length' => '验证码必须是6位纯数字',
        'nickname.require' => '昵称不能为空',
        'nickname.length' => '昵称在4至16个字符之间',
        'password.require' => '密码不能为空',
        'password.length' => '密码在6至20个字符之间'
    ];

}