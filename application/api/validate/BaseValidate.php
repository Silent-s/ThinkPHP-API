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
    public function checkParams($scene = '')
    {
        $params = Request::param();
        // 对参数进行校验
        $result = $scene ? $this->scene($scene)->check($params)
            : $this->check($params);
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

    /**
     * 验证是否是正整数
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool|string
     */
    protected function isPositiveInteger($value, $rule='', $data='', $field='')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
        return false;
    }

    /**
     * 过滤user_id或者uid
     * @param $arrays
     * @return array
     * @throws ParameterException
     */
    public function getDataByRule($arrays, $action = '')
    {
        if (array_key_exists('user_id', $arrays) | array_key_exists('uid', $arrays)) {
            // 不允许包含user_id或者uid，防止恶意覆盖user_id外键
            throw new ParameterException([
                'msg' => '参数中包含有非法的参数名user_id或者uid'
            ]);
        }
        $newArray = [];
        if ($action) {
            foreach ($this->scene[$action] as $value) {
                $newArray[$value] = $arrays[$value];
            }
        } else {
            foreach ($this->rule as $key => $value) {
                $newArray[$key] = $arrays[$key];
            }
        }
        return $newArray;
    }
}