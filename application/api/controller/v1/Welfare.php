<?php

namespace app\api\controller\v1;

use app\api\library\exception\ParameterException;
use app\api\validate\RedEnvelope;
use Predis\Client;
use think\Controller;
use think\facade\Cache;
use think\Request;

class welfare extends Controller
{
    /**
     * 发红包(预先生成) 注意权限
     *
     * @method    POST
     * @url       /api/v1/red_envelope
     */
    public function grabRedEnvelope(Request $request)
    {
        set_time_limit(0);
        (new RedEnvelope())->checkParams();

        $money = $request->post('money');
        $num = $request->post('num');
        for ($i = 0; $i < $money - 1; $i++) {
            $max = (int)floor($money / ($num - $i)) * 2;
            $redmoney[$i] = $max ? mt_rand(1, $max) : 0;
            $money -= $redmoney[$i];
        }
        $redmoney[] = $money;
        // 放入redis的list,键值为red::list
        $sentinels = array(
            'host' => '47.105.150.138',
            'port' => 6379,
            'password' => 'silent',
        );
        $client = new Client($sentinels);
        $client->del("red::list");
        foreach ($redmoney as $key => $value) {
            $client->lpush("red::list", $value);
        }
    }

    /**
     * 抢红包 用户操作
     *
     * @method    POST
     * @url       /api/v1/red_envelopes
     */
    public function redEnvelopes()
    {
        $charid = strtoupper(md5(uniqid(mt_rand(), true)));
        $uuid = substr($charid, 0, 8) . substr($charid, 8, 4) . substr($charid, 12, 4) . substr($charid, 16, 4) . substr($charid, 20, 12);
        $sentinels = array(
            'host' => '47.105.150.138',
            'port' => 6379,
            'password' => 'silent',
        );
        $client = new Client($sentinels);
        // 领取人信息
        $isDraw = $client->hexists('red::draw', $uuid);
        if ($isDraw && $isDraw !== 0) {
            throw new ParameterException([
                'msg' => '已经领取',
            ]);
        }
        // 领取太多次了
        $times = $client->incr('red::draw_count:u:' . $uuid);
        if ($times && $times > 1) {
            throw new ParameterException([
                'msg' => '超过领取限制了',
            ]);
        }
        // 抢占红包
        $number = $client->rpop('red::list');
        if (!$number) {
            throw new ParameterException([
                'msg' => '不好意思,红包领取完了',
            ]);
        }
        // 生成信息,放入队列处理
        $getredinfo = [
            'uuid' => $uuid,
            'money' => $number,
        ];
        // 领取记录
        $client->hset('red::draw', $uuid, json_encode($getredinfo));
        // 处理队列
        $client->rpush('red::task', json_encode($getredinfo));
        return json([
            'msg' => '抢购成功'
        ]);
    }

}