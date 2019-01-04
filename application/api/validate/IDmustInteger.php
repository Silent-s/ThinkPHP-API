<?php

namespace app\api\validate;

/**
 * 验证ID是否是正整数
 */
class IDmustInteger extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
    ];

    protected $message = [
        'id.require' => 'id参数必须传入',
        'id.isPositiveInteger' => 'id必须是正整数'
    ];
}