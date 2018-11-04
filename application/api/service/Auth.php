<?php

namespace app\api\service;

use app\api\library\enum\UserStatusEnum;
use app\api\library\exception\UserException;
use app\api\model\User as UserModel;
use think\facade\Cache;

class Auth
{
    /**
     * 用户登录
     *
     * @param     string  account     账号
     * @param     string  password    密码
     * @return    boolean
     */
    public function login($account, $password)
    {
        // 验证用户是否存在
        $userData = UserModel::get(['mobile' => $account]);
        if (!$userData) {
            throw new UserException();
        }
        // 验证用户状态是否正常
        if ($userData->status != UserStatusEnum::Status_Ok) {
            throw new UserException([
                'httpCode' => 410,
                'msg' => '账号已经被锁定',
                'errorCode' => 20001
            ]);
        }
        // 验证用户密码是否正确
        if ($userData->password != $this->getEncryptPassword(
                $password, $userData->salt)) {
            throw new UserException([
                'httpCode' => 401,
                'msg' => '账号密码错误',
                'errorCode' => 20002
            ]);
        }
        return $userData;
    }

    /**
     * 用户注册
     *
     * @param $mobile_number
     * @param $verify_code
     * @param $password
     * @param $nickname
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
        $user = UserModel::create([
            'mobile_number' => $mobile_number,
            'nickname' => $nickname,
            'salt' => $salt,
            'password' => $this->getEncryptPassword($password, $salt)
        ]);
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