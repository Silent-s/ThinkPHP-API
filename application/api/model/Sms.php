<?php

namespace app\api\model;

use think\model\concern\SoftDelete;

class Sms
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
     * 获取最后一次手机发送的数据
     *
     * @param   int      $mobile 手机号
     * @param   string   $event 事件
     * @return  Sms
     */
    public static function getLastTime($mobile, $event = 'default')
    {
        $sms = self::where(['mobile' => $mobile, 'event' => $event])
            ->order('id', 'desc')
            ->find();
        return $sms ? $sms : null;
    }
}