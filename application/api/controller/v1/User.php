<?php

namespace app\api\controller\v1;

use app\api\service\AppToken as AppTokenService;
use think\Controller;
use app\api\service\Auth as AuthService;
use app\api\validate\UserLogin as UserLoginValidate;


/**
 * 会员接口
 * @author Yang <zttvi@outlook.com>
 */
class User extends Controller
{
    /**
     * 会员登录(换取Token)
     *
     * @method    GET
     * @url       /api/v1/user/login
     * @param     string  account     账号
     * @param     string  password    密码
     */
    public function login()
    {
        (new UserLoginValidate())->checkParams();

        $account  = $this->request->post('account');
        $password = $this->request->post('password');
        $authService = new AuthService();
        $result = $authService->login($account, $password);
        if ($result) {
            $appTokenService = new AppTokenService();
            $token = $appTokenService->createData($result);
            return [
                'access_token' => $token,
                'expires_in'   => 7200,
                'token_type'   => 'bearer',
                'refresh_token'=> $token
            ];
        }
    }


    /**
     * 会员注册
     *
     * @method    GET
     * @url       /api/v1/user/register
     * @param     string  username    用户名
     * @param     string  password    密码
     * @param     string  email       邮箱
     * @param     string  mobile      手机号
     */
    public function register()
    {

    }
}