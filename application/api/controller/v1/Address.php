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

    private $address;

    private $address_id;

    /**
     * 前置操作,主要是检查地址数据是否存在
     *
     * @var array
     */
    protected $beforeActionList = [
        'checkUserAddress' => ['except' => 'addUserAddress,
                       editUserAddress,listUserAddress']
    ];

    /**
     * 不需要自动验证的方法
     *
     * @var array
     */
    protected $noNeedValidate = ['listUserAddress'];

    /**
     * 初始化操作
     * 自动验证和获取用户id
     */
    protected function initialize()
    {
        $this->action = $this->request->action(true);
        if (!in_array($this->action, $this->noNeedValidate, true)) {
            $this->validate = new UserAddressValidate();
            $this->validate->checkParams($this->action);
        }
        $this->uid = AppTokenService::getCurrentTokenVar('uid');
    }

    /**
     * 检查数据id是否存在
     */
    public function checkUserAddress()
    {
        $id = $this->request->param('id');
        $data = AddressModel::get(['id' => $id, 'user_id' => $this->uid]);
        if (!$data) {
            throw new UserAddressException();
        }
        $this->address = $data;
        $this->address_id = $id;
    }

    /**
     * 添加用户收货地址
     *
     * @url      api/v1/address
     * @method   POST
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
     * @url      api/v1/address
     * @method   POST
     */
    public function editUserAddress()
    {
        $params = $this->request->post();
        $data = $this->validate->getDataByRule($params, $this->action);
        AddressModel::update($data);
    }


    /**
     * 获取用户地址列表数据
     *
     * @url     api/v1/address?page=1&size=20
     * @method  GET
     */
    public function listUserAddress($page = 1, $size = 20)
    {
        $pageAddress = AddressModel::getAddressByPage($page, $size);
        return [
            'current_page' => $pageAddress->currentPage(),
            'data' => $pageAddress->isEmpty() ? [] : $pageAddress
        ];
    }


    /**
     * 获取指定id的地址数据
     *
     * @url     api/v1/address/:id
     * @method  GET
     */
    public function getUserAddressOne()
    {
        return $this->address;
    }


    /**
     * 删除指定id的地址数据
     *
     * @url     api/v1/address/:id
     * @method  DELETE
     */
    public function delUserAddressOne()
    {
        return $this->address->delete();
    }

}