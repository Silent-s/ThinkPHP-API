<?php

namespace app\api\validate;

/**
 * 修改用户信息场景
 */
class ModifyUserInfo extends BaseValidate
{
    protected $rule =   [
        'username'  => 'require|max:25',
        'nickname'  => 'require|max:25',
    ];

    protected $message  =   [
        'username.require' => '用户名不能为空',
        'username.max'     => '用户名最多不能超过25个字符',
        'nickname.require' => '昵称不能为空',
        'nickname.max'     => '昵称最多不能超过25个字符',
    ];

    protected $scene = [
        'modifyUsername'  =>  ['username'],
        'modifyNickname'  =>  ['nickname']
    ];
}