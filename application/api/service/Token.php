<?php

namespace app\api\service;

use app\api\library\exception\TokenException;
use think\Exception;
use think\facade\Cache;
use think\Request;

class Token
{
    /**
     * 生成随机令牌
     * @return string
     */
    public static function generateToken()
    {
        $randChar = uniqid(microtime(true), true);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $tokenSalt = config('secure.token_salt');
        return md5($randChar . $timestamp . $tokenSalt);
    }

    /**
     * 获取指定token变量的字段
     * @param $key
     * @return mixed
     * @throws Exception
     * @throws TokenException
     */
    public static function getCurrentTokenVar($key)
    {
        $token = Request::header('token');
        $vars = Cache::get($token);
        if (!$vars) {
            throw new TokenException();
        }
        if (!is_array($vars)) {
            $vars = json_decode($vars, true);
        }
        if (array_key_exists($key, $vars)) {
            return $vars[$key];
        }
        throw new Exception('尝试获取Token变量并不存在');
    }

}