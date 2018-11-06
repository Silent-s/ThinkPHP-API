<?php

namespace app\api\validate;

/**
 * 刷新Token不能为空
 */
class RefreshToken extends BaseValidate
{
    protected $rule = [
        'authorization'  => 'require',
    ];

    protected $message = [
        'authorization.require'  => '刷新Token不能为空',
    ];
}