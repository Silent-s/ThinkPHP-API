<?php

namespace app\api\model;

use think\Model;
use think\model\concern\SoftDelete;

class User extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    /**
     * 检查手机号码是否已被注册
     *
     * @param $mobile_number
     * @return float|string
     */
    public static function findByMobileNumber($mobile_number)
    {
        return self::where('mobile_number', '=', $mobile_number)->count();
    }

    /**
     * 检查用户昵称是否已被注册
     *
     * @param $nickname
     * @return float|string
     */
    public static function findByNickname($nickname)
    {
        return self::where('nickname', '=', $nickname)->count();
    }

}