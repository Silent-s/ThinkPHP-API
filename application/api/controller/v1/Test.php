<?php
/**
 * Created by PhpStorm.
 * User: Silent
 * Date: 2018/11/5
 * Time: 18:25
 */

namespace app\api\controller\v1;


use Firebase\JWT\JWT;
use think\facade\Request;

class Test
{
    public function test()
    {
        $key = config('jwt.token_salt');
        $nowtime = time();
        $token = array(
            "iss" => "http://example.org",   //签发者
            "aud" => "http://example.com",   // jwt所面向的用户
            "iat" => $nowtime,               // 签发时间
            "nbf" => $nowtime + 121,              // 在什么时间后该jwt可以使用
            "data" => [
                'user_id' => 1,
                'scope' => 2,
                'create_token_time' => $nowtime
            ]
        );

        // access_token
        $access_token = $token;
        $access_token['scopes'] = 'role_access';
        $access_token['exp'] = $nowtime + 20;

        // refresh_token
        $refresh_token = $token; //refresh_token
        $refresh_token['scopes'] = 'role_refresh'; //token标识，刷新access_token
        $refresh_token['exp'] = $nowtime + (86400 * 30); //refresh_token过期时间,这里设置30天

        $jsonList = [
            'access_token' => JWT::encode($access_token, $key),
            'refresh_token' => JWT::encode($refresh_token, $key),
            'token_type' => 'bearer' //token_type：表示令牌类型，该值大小写不敏感，这里用bearer
        ];
        dump($jsonList);
    }


    public function test2()
    {
       $jwt = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLm9yZyIsImF1ZCI6Imh0dHA6XC9cL2V4YW1wbGUuY29tIiwiaWF0IjoxNTQxNDI3MTk1LCJuYmYiOjE1NDE0MjczMTYsImRhdGEiOnsidXNlcl9pZCI6MSwic2NvcGUiOjIsImNyZWF0ZV90b2tlbl90aW1lIjoxNTQxNDI3MTk1fSwic2NvcGVzIjoicm9sZV9hY2Nlc3MiLCJleHAiOjE1NDE0MjcyMTV9.Oc0KsyD4BWIhjWjf_F2Dbl9Q8Fd-rbQ_dr45ptozQWU";
        $key = "example_key";
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        dump($decoded);
    }

    public function test3()
    {
//        $key = "example_key";
//        $authorization = Request::header('authorization');
//        sscanf($authorization, "Bearer %s", $jwt);
//        $data = (array)JWT::decode($jwt, $key, array('HS256'));
//        if ($data['exp'] > time()) {
//            dump($data);
//        }
        dump(\app\api\service\Token::getCurrentTokenVar('user_id'));
    }

//    pu
}