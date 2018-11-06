<?php

namespace app\api\validate;

use app\api\library\exception\ParameterException;
use think\facade\Request;
use think\Validate;

/**
 * 父类验证
 */
class BaseValidate extends Validate
{
    /**
     * 统一参数层验证
     * @return bool
     * @throws ParameterException
     */
    public function checkParams()
    {
        $params  = Request::param();
        // 对参数进行校验
        $result  = $this->check($params);
        if (false === $result) {
            throw new ParameterException([
                'msg' => $this->error
            ]);
        }
        return true;
    }

    /**
     * 验证是否为手机号
     * @param $value
     * @return bool
     */
    protected function isMobile($value)
    {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}