<?php

namespace app\api\service;

use app\api\library\enum\UserStatusEnum;
use app\api\library\exception\UserException;
use app\api\model\User as UserModel;

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