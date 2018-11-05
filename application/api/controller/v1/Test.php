<?php
/**
 * Created by PhpStorm.
 * User: Silent
 * Date: 2018/11/5
 * Time: 18:25
 */

namespace app\api\controller\v1;


use Firebase\JWT\JWT;

class Test
{
    public function test()
    {
        $key = "example_key";
        $nowtime = time();
        $token = array(
            "iss" => "http://example.org",   //签发者
            "aud" => "http://example.com",   // jwt所面向的用户
            "iat" => $nowtime,             // 签发时间
            "nbf" => $nowtime,              // 在什么时间后该jwt可以使用
            "exp" => $nowtime + 10          // 十秒后过期
        );

        /**
         * IMPORTANT:
         * You must specify supported algorithms for your application. See
         * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
         * for a list of spec-compliant algorithms.
         */
        // 加密
        $jwt = JWT::encode($token, $key);
        dump('加密Token:' . $jwt);
        // 解密
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        dump($decoded);

        /*
         NOTE: This will now be an object instead of an associative array. To get
         an associative array, you will need to cast it as such:
        */

        $decoded_array = (array)$decoded;

        dump($decoded_array);

        /**
         * You can add a leeway to account for when there is a clock skew times between
         * the signing and verifying servers. It is recommended that this leeway should
         * not be bigger than a few minutes.
         *
         * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
         */
        JWT::$leeway = 60; // $leeway in seconds
        $decoded = JWT::decode($jwt, $key, array('HS256'));

    }


    public function test2(){
        $jwt = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLm9yZyIsImF1ZCI6Imh0dHA6XC9cL2V4YW1wbGUuY29tIiwiaWF0IjoxNTQxNDE0MjQ0LCJuYmYiOjE1NDE0MTQyNDQsImV4cCI6MTU0MTQxNDI1NH0.NVAMJA3JaZUbp8ftGEEIROWslF2oOQaUyCgiXIdspwg";
        $key = "example_key";
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        dump($decoded);
    }
}