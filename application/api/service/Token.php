<?php

namespace app\api\service;

use app\api\library\exception\TokenException;
use Firebase\JWT\JWT;
use think\Exception;
use think\facade\Cache;
use think\facade\Request;

class Token
{
    /**
     * 签发 access_token 和 refresh_token
     * @param $user_id
     * @return array
     */
    public static function issueToken($user_id)
    {
        $key = config('jwt.token_salt');
        $time = time();
        $token = [
            'iss' => Request::url(true),  // 签发着
            'iat' => $time,                       //签发时间
            'data' => [                           // 自定义信息
                'user_id' => $user_id
            ]
        ];
        // access_token
        $access_token = $token;
        $access_token['scopes'] = 'role_access';
        $access_token['exp'] = $time + 7200;
        // refresh_token
        $refresh_token = $token;
        $refresh_token['scopes'] = 'role_refresh';
        $refresh_token['exp'] = $time + (86400 * 7);
        $jsonList = [
            'access_token' => JWT::encode($access_token, $key),
            'refresh_token' => JWT::encode($refresh_token, $key),
            'token_type' => 'bearer' //token_type：表示令牌类型，该值大小写不敏感，这里用bearer
        ];
        return $jsonList;
    }

    /**
     * 获取指定jwt-token变量的字段
     * @param $key
     * @return mixed
     * @throws Exception
     * @throws TokenException
     */
    public static function getCurrentTokenVar($key)
    {
        $saltkey = config('jwt.token_salt');
        $authorization = Request::header('authorization');
        sscanf($authorization, "Bearer %s", $jwt);
        $data = (array)JWT::decode($jwt, $saltkey, array('HS256'));
        if (!$data) {
            throw new TokenException();
        }
        $listdata = (array)$data['data'];
        if (array_key_exists($key, $listdata)) {
            return $listdata[$key];
        }
        throw new Exception('尝试获取Token变量并不存在');
    }

}