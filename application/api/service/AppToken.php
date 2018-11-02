<?php

namespace app\api\service;

use app\api\library\exception\ParameterException;

class AppToken extends Token
{
    /**
     * 返回客户端Token
     * @param $user
     * @return string
     * @throws ParameterException
     */
    public function createData($user)
    {
        $values = [
            'uid' => $user->id,
            'create_time' => time()
        ];
        $token = $this->saveToCache($values);
        return $token;
    }

    /**
     * 缓存Token
     * @param $values
     * @return string
     * @throws ParameterException
     */
    private function saveToCache($values)
    {
        $token = self::generateToken();
        $expire_in = config('setting.token_expire_in');
        $result = cache($token, json_encode($values), $expire_in);
        if (!$result) {
            throw new ParameterException([
                'msg' => '服务器缓存异常',
                'errorCode' => 20004
            ]);
        }
        return $token;
    }
}