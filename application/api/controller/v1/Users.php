<?php

namespace app\api\controller\v1;

use app\api\validate\UserRegister as UserRegisterValidate;
use app\api\service\Auth as AuthService;
use app\lib\exception\SuccessMessage;
use think\Controller;

class Users extends Controller
{
    /**
     * 会员注册
     *
     * @method    POST
     * @url       /api/v1/users
     * @param     string  mobile_number  手机号码
     * @param     string  verify_code    手机验证码
     * @param     string  password       输入密码(至少6位)
     * @param     string  nickname       输入昵称
     * @throws    \app\api\library\exception\ParameterException
     * @throws    \app\api\library\exception\UserException
     * @return    SuccessMessage
     */
    public function store()
    {
        (new UserRegisterValidate())->checkParams();

        $mobile_number = $this->request->post('mobile_number');
        $verify_code = $this->request->post('verify_code');
        $password = $this->request->post('password');
        $nickname = $this->request->post('nickname');
        $auth = new AuthService();
        $auth->register($mobile_number, $verify_code, $password, $nickname);
        return new SuccessMessage([
            'msg' => '注册成功'
        ]);
    }
}