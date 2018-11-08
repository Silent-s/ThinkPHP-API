<?php

namespace app\api\validate;

/**
 * 修改用户信息验证
 */
class ModifyUserInfo extends BaseValidate
{
    protected $rule = [
        'username' => 'require|length:2,10',
        'nickname' => 'require|length:2,10',
        'avatar'   => 'require'
    ];

    protected $message = [
        'username.require' => '用户名不能为空',
        'username.length'  => '用户名在2-10个字符之间',
        'nickname.require' => '昵称不能为空',
        'nickname.length'  => '昵称在2-10个字符之间',
        'avatar'           => '头像不能为空'
    ];

    protected $scene = [
        'modifyUsername' => ['username'],
        'modifyNickname' => ['nickname'],
        'modifyAvatar'   => ['avatar']
    ];
}