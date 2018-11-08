<?php

namespace app\api\model;

use think\Model;
use think\model\concern\SoftDelete;

class Address extends Model
{
    use SoftDelete;

    // 只读字段
    protected $readonly = ['user_id'];

    // 不需要显示的字段
    protected $hidden = ['create_time', 'update_time', 'delete_time', 'user_id'];

    // 软删除标记字段
    protected $deleteTime = 'delete_time';

    // 定义软删除字段的默认值
    protected $defaultSoftDelete = 0;

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

}