<?php

namespace app\api\validate;

class RedEnvelope extends BaseValidate
{
    protected $rule = [
        'money'  => 'require',
        'num'    => 'require|isPositiveInteger',
    ];

    protected $message = [
        'money.require'  => '金额不能为空',
        'num.require'    => '数量不能为空',
        'num.isPositiveInteger' => '数量必须是正整数'
    ];
}