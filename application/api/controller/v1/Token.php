<?php

namespace app\api\controller\v1;

use think\Controller;
use app\api\library\exception\SuccessMessage;
use app\api\validate\UserLogin as UserLoginValidate;
use app\api\validate\RefreshToken as RefreshTokenValidate;
use app\api\service\AppToken as AppTokenService;
use think\facade\Request;


class Token extends Controller
{
    /**
     * 会员登录(限制请求次数)
     *
     * @method    POST
     * @url       /api/v1/token
     * @param     string  telphone       手机号码
     * @param     string  password       输入密码
     * @throws    \app\api\library\exception\ParameterException
     * @throws    \app\api\library\exception\UserException
     * @throws    \think\Exception\DbException
     * @return    array
     */
    public function getToken()
    {
        (new UserLoginValidate())->checkParams();

        $telphone  = $this->request->post('telphone');
        $password  = $this->request->post('password');
        $userToken = new AppTokenService();
        $token     = $userToken->validateUser($telphone, $password);
        return $token;
    }


    /**
     * 刷新Token(限制请求次数)
     * @method    POST
     * @url       /api/v1/refresh_token
     * @param     string   authorization  刷新Token('Bearer token')
     * @throws    \app\api\library\exception\ForbiddenException
     * @throws    \app\api\library\exception\ParameterException
     * @return    array
     */
    public function refreshToken()
    {
        (new RefreshTokenValidate())->checkParams();

        $refresh   = Request::post('authorization');
        $userToken = new AppTokenService();
        $token     = $userToken->refreshToken($refresh);
        return $token;
    }
}