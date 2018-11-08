<?php

namespace app\api\validate;

/**
 * 用户地址
 */
class UserAddress extends BaseValidate
{
    protected $rule = [
        'receiver'    => 'require|length:2,10',
        'telphone'    => 'require|isMobile',
        'province'    => 'require',
        'province_id' => 'require',
        'city'        => 'require',
        'city_id'     => 'require',
        'area'        => 'require',
        'area_id'     => 'require',
        'address'     => 'require|length:2,20',
        'id'          => 'require|isPositiveInteger',
    ];

    protected $message = [
        'receiver.require'    => '请填写收货人姓名',
        'receiver.length'     => '收货人姓名在2至10个字符之间',
        'telphone.require'    => '手机号码不能为空',
        'telphone.isMobile'   => '手机号码格式不正确',
        'province.require'    => '请选择所在地区',
        'province_id.require' => '请选择所在地区',
        'city.require'        => '请选择所在地区',
        'city_id.require'     => '请选择所在地区',
        'area.require'        => '请选择所在地区',
        'area_id.require'     => '请选择所在地区',
        'address.require'     => '请输入详细地址,如街道,门牌号等',
        'address.length'      => '详细地址在2至20个字符之间',
        'id.require'          => '数据传输不完整,请检查参数'
    ];

    protected $scene = [
        'addUserAddress'    => ['receiver', 'telphone', 'province', 'province_id', 'city', 'city_id', 'area', 'area_id', 'address'],
        'editUserAddress'   => ['receiver', 'telphone', 'province', 'province_id', 'city', 'city_id', 'area', 'area_id', 'address', 'id'],
        'getUserAddressOne' => ['id'],
        'delUserAddressOne' => ['id']
    ];

}