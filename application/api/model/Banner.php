<?php

namespace app\api\model;

use think\Model;
use think\model\concern\SoftDelete;

class Banner extends Model
{
    use SoftDelete;

    // 不需要显示的字段
    protected $hidden = ['create_time', 'update_time', 'delete_time'];

    // 软删除标记字段
    protected $deleteTime = 'delete_time';

    // 定义软删除字段的默认值
    protected $defaultSoftDelete = 0;

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    /**
     * 获取指定banner信息
     *
     * @param $id
     */
    public static function getBannerById($id)
    {
        $banner = self::with(['items','items.img'])
            ->find($id);
        return $banner;
    }
}