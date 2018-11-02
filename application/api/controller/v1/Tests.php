<?php

namespace app\api\controller\v1;

use Firebase\JWT\JWT;

class Tests
{
    public function test()
    {
        $nowtime = 1541142798;
        $token = [
            'iss' => 'http://www.helloweba.net', //签发者
            'aud' => 'http://www.helloweba.net', //jwt所面向的用户
            'iat' => $nowtime,                   //签发时间
            'nbf' => $nowtime,                   //在什么时间之后该jwt才可用
            'exp' => $nowtime + 60,             //过期时间-10min
            'data' => [
                'userid' => 1,
                'username' => '123456'
            ]
        ];
        $jwt = JWT::encode($token, '1gHuiop975cdashyex9Ud23ldsvm2Xq');
        $res['result'] = 'success';
        $res['jwt'] = $jwt;

        $decoded = JWT::decode($jwt, '1gHuiop975cdashyex9Ud23ldsvm2Xq', array('HS256'));

        $decoded_array = (array) $decoded;
        dump($decoded_array);
    }
}