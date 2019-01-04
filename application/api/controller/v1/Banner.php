<?php

namespace app\api\controller\v1;

use think\Controller;
use app\api\validate\IDmustInteger as IDmustIntegerValidate;

class Banner extends Controller
{
    /**
     * 获取指定位置的banner数据
     *
     * @url       /api/v1/banner/:id
     * @method    GET
     */
    public function getBanner()
    {
        (new IDmustIntegerValidate())->checkParams();

    }
}