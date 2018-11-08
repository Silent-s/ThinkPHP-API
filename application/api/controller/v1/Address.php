<?php

namespace app\api\controller\v1;

use app\api\library\exception\UserAddressException;
use app\api\validate\UserAddress;
use think\Controller;
use app\api\model\Address as AddressModel;
use app\api\service\AppToken as AppTokenService;
use app\api\validate\UserAddress as UserAddressValidate;

class Address extends Controller
{
    private $uid;

    private $action;

    private $validate;

    private $address_id;

    /**
     * 前置操作,主要是检查地址数据是否存在
     *
     * @var array
     */
    protected $beforeActionList = [
        'checkUserAddress' => ['except' => 'addUserAddress']
    ];

    /**
     * 初始化操作
     *
     * @throws   \app\api\library\exception\ParameterException
     * @throws   \app\api\library\exception\TokenException
     * @throws   \think\Exception
     */
    protected function initialize()
    {
        $this->action = $this->request->action(true);
        $this->validate = new UserAddressValidate();
        $this->validate->checkParams($this->action);
        $this->uid = AppTokenService::getCurrentTokenVar('uid');
    }

    /**
     * 检查数据ID是否存在
     *
     * @throws UserAddressException
     * @throws \think\Exception\DbException
     */
    public function checkUserAddress()
    {
        $id = $this->request->param('id');
        $data = AddressModel::get(['id' => $id, 'user_id' => $this->uid]);
        if (!$data) {
            throw new UserAddressException();
        }
        $this->address_id = $id;
    }

    /**
     * 添加用户收货地址
     *
     * @url   api/v1/address
     * @method   POST
     *
     */
    public function addUserAddress()
    {
        $params = $this->request->post();
        $data = $this->validate->getDataByRule($params, $this->action);
        $data['user_id'] = $this->uid;
        $result = AddressModel::create($data);
    }

    /**
     * 编辑用户地址
     *
     */
    public function editUserAddress()
    {

    }


    /**
     * 删除用户地址数据
     *
     */
    public function listUserAddress()
    {
        $result =

    }


    /**
     * 获取指定id的地址数据
     *
     * @param $id
     */
    public function getUserAddressOne()
    {
        $data = AddressModel::get(['id' => $this->address_id, 'user_id' => $this->uid]);
        return $data;
    }


    /**
     * 删除指定id的地址数据
     *
     *
     */
    public function delUserAddressOne()
    {
        $id = $this->request->param('id');
    }

}