<?php

namespace app\api\controller\v1;

use app\api\model\User as UserModel;
use app\api\service\AppToken as AppTokenService;
use app\api\validate\ModifyUserInfo as ModifyUserInfoValidate;
use think\Controller;

/**
 * 用户修改验证
 * @author <zttvi@outlook.com>
 */
class Users extends Controller
{
    private $uid;

    private $action;

    /**
     * 初始化操作
     * @throws   \app\api\library\exception\ParameterException
     * @throws   \app\api\library\exception\TokenException
     * @throws   \think\Exception
     */
    protected function initialize()
    {
        $this->action = $this->request->action(true);
        (new ModifyUserInfoValidate())->checkParams($this->action);
        $this->uid    = AppTokenService::getCurrentTokenVar('uid');
    }


    /**
     * 修改用户名
     *
     * @method    PUT
     * @url       /api/v1/user/username
     * @param     string   username  修改的用户名
     */
    public function modifyUsername()
    {
        $username = $this->request->param('username');
        $result   = UserModel::update(['username' => $username], ['id' => $this->uid]);
    }


    /**
     * 修改昵称
     *
     * @method    PUT
     * @url       /api/v1/user/nickname
     * @param     string   nickname  修改的昵称
     */
    public function modifyNickname()
    {
        $nickname = $this->request->param('nickname');
        $result   = UserModel::update(['nickname' => $nickname], ['id' => $this->uid]);
    }

    /**
     * 修改头像
     *
     * @method    PUT
     * @url       /api/v1/user/avatar
     * @param     string   userhead  修改的头像
     */
    public function modifyAvatar()
    {
        $avatar = $this->request->param('avatar');
        $result   = UserModel::update(['avatar' => $avatar], ['id' => $this->uid]);
    }
}