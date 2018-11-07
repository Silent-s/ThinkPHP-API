<?php

namespace app\api\model;

use think\facade\Request;
use think\Model;
use think\model\concern\SoftDelete;

class User extends Model
{
    use SoftDelete;

    protected $hidden = ['password', 'salt', 'token',
        'status', 'logintime', 'loginip', 'loginfailure', 'joinip', 'jointime',
        'token', 'verification', 'avatar', 'delete_time', 'create_time', 'update_time', 'prevtime'];

    protected $deleteTime = 'delete_time';

    protected $defaultSoftDelete = 0;

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    protected $append = [
        'avatr_text',
        'prevtime_text'
    ];

    /**
     * 获取用户头像并修改
     *
     * @param $value
     * @param $data
     * @return string
     */
    public function getAvatrTextAttr($value, $data)
    {
        $value = $value ? $value : $data['avatar'];
        $value = Request::domain() . $value;
        return $value;
    }

    /**
     * 格式化上次登录时间
     *
     * @param $value
     * @param $data
     * @return false|string
     */
    public function getPrevtimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['prevtime'];
        $value = date('Y-m-d', $value);
        return $value;
    }

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