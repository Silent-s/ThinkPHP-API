<?php

namespace app\api\service;

use app\api\library\enum\UserStatusEnum;
use app\api\library\exception\ForbiddenException;
use app\api\library\exception\UserException;
use app\api\model\User as UserModel;
use Firebase\JWT\JWT;
use think\facade\Request;

class AppToken extends Token
{
    protected $token_salt;

    /**
     * 初始化操作
     * AppToken constructor.
     */
    public function __construct()
    {
        $this->token_salt = config('secure.token_salt');
    }

    /**
     * 验证用户并生成Token
     * @param $telphone
     * @param $password
     * @return array
     * @throws UserException
     * @throws \think\Exception\DbException
     */
    public function validateUser($telphone, $password)
    {
        $userData = UserModel::get(['telphone' => $telphone]);
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
        $cachedValue = $this->prepareCachedValue($userData->id);
        return $this->grantToken($cachedValue);
    }

    /**
     * 生成Token
     * @param $cachedValue
     * @return array
     */
    public function grantToken($cachedValue)
    {
        $nowtime = time();
        $token = array(
            "iss"  => Request::domain(),      // 签发者
            "aud"  => Request::domain(),      // jwt所面向的用户
            "iat"  => $nowtime,               // 签发时间
            "nbf"  => $nowtime,               // 在什么时间后该jwt可以使用
            "data" => $cachedValue            // 自定义数据
        );
        // access_token
        $access_token = $token;
        $access_token['scopes'] = 'role_access';
        $access_token['exp']    = $nowtime + 7200;

        // refresh_token
        $refresh_token = $token;
        $refresh_token['scopes'] = 'role_refresh';
        $refresh_token['exp']    = $nowtime + (86400 * 7);

        $jsonList = [
            'access_token'  => JWT::encode($access_token, $this->token_salt),
            'refresh_token' => JWT::encode($refresh_token, $this->token_salt),
            'token_type'    => 'bearer'
        ];
        return $jsonList;
    }

    /**
     * 刷新Token
     * @param $refreshToken
     * @return array
     * @throws ForbiddenException
     */
    public function refreshToken($refreshToken)
    {
        sscanf($refreshToken, "Bearer %s", $jwt);
        $data = (array)JWT::decode($jwt, $this->token_salt, array('HS256'));
        if($data['scopes'] != 'role_refresh'){
            // 不是刷新Token,停止用户操作
            throw new ForbiddenException();
        }
        $nowtime = time();
        $token = array(
            "iss"  => Request::domain(),      // 签发者
            "aud"  => Request::domain(),      // jwt所面向的用户
            "iat"  => $nowtime,               // 签发时间
            "nbf"  => $nowtime,               // 在什么时间后该jwt可以使用
            "data" => (array)$data['data']    // 自定义数据
        );
        // access_token
        $access_token = $token;
        $access_token['scopes'] = 'role_access';
        $access_token['exp']    = $nowtime + 7200;
        $jsonList = [
            'access_token'  => JWT::encode($access_token, $this->token_salt),
            'token_type'    => 'bearer'
        ];
        return $jsonList;
    }

    /**
     * 设置自定义数据
     * @param $uid
     * @return mixed
     */
    private function prepareCachedValue($uid)
    {
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = 2;
        return $cachedValue;
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