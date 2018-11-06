<?php

namespace app\api\service;

use app\api\library\exception\UserException;
use app\api\model\User as UserModel;
use think\facade\Cache;

class Auth
{
    /**
     * 用户注册
     *
     * @param $mobile_number
     * @param $verify_code
     * @param $password
     * @param $nickname
     * @throws UserException
     */
    public function register($mobile_number, $verify_code, $password, $nickname)
    {
        $verify_data = Cache::get($verify_code);
        if (!$verify_data) {
            throw new UserException([
                'httpCode' => 422,
                'msg' => '验证码已失效',
                'errorCode' => 20003
            ]);
        }
        if (!hash_equals($verify_data['code'], $verify_code)) {
            throw new UserException([
                'httpCode' => 401,
                'msg' => '验证码错误',
                'errorCode' => 20004
            ]);
        }
        if (!UserModel::findByMobileNumber($mobile_number)) {
            throw new UserException([
                'httpCode' => 410,
                'msg' => '手机号码已存在',
                'errorCode' => 20005
            ]);
        }
        if (!UserModel::findByNickname($nickname)) {
            throw new UserException([
                'httpCode' => 410,
                'msg' => '用户昵称已存在',
                'errorCode' => 20006
            ]);
        }
        // 创建用户
        $salt = uniqid();
        //
        UserModel::create([
            'mobile_number' => $mobile_number,
            'nickname' => $nickname,
            'salt' => $salt,
            'password' => $this->getEncryptPassword($password, $salt)
        ]);
        return true;
    }

    /**
     * 获取密码加密后的字符串
     * @param string $password 密码
     * @param string $salt 密码盐
     * @return string
     */
    public function getEncryptPassword($password, $salt = '')
    {
        return md5(md5($password) . $salt);
    }
}