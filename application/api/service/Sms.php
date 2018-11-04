<?php

namespace app\api\service;

use app\api\library\exception\UserException;
use app\api\model\Sms as SmsModel;

class Sms
{
    public static function send($mobile_number, $event)
    {
        $last = SmsModel::getLastTime($mobile_number, $event);
        if ($last && time() - $last['create_time']) {
            throw new UserException([
                'httpCode' => '',
                'msg' => '短信发送频繁',
            ])
        }
    }
}