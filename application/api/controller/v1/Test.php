<?php
/**
 * Created by PhpStorm.
 * User: silent
 * Date: 2018/12/26
 * Time: 13:10
 */

namespace app\api\controller\v1;


use Pheanstalk\Pheanstalk;

class Test
{
    public function test()
    {
        set_time_limit(0);
        $pheanstalk = new Pheanstalk('47.105.150.138');
        for ($i = 0; $i < 5000; $i++) {
            sleep(1);
            $str = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $data = ['user_id' => uniqid(), 'time' => time(), 'order_sn' => $str];
            $pheanstalk->useTube('ordertube')->put(json_encode($data), 1000, 10,600);
        }
        // 有可能是0元  在抢占的时候  如果为0就告诉用户未领取到
//        $M = 10000;
//        $N = 527;
//        for ($i = 0; $i < $N - 1; $i++) {
//            $max = (int)floor($M / ($N - $i)) * 2;
//            $m[$i] = $max ? mt_rand(1, $max) : 0;
//            $M -= $m[$i];
//        }
//
//        $m[] = $M;
//        dump($m);
    }
}