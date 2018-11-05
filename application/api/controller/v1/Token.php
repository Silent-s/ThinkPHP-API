<?php

namespace app\api\controller\v1;

use Firebase\JWT\JWT;
use think\Controller;
use think\facade\Request;

class Token extends Controller
{
    public function token()
    {
        $key = config('jwt.token_salt');
        $authorization = Request::header('authorization');
        sscanf($authorization, "Bearer %s", $jwt);
        $data = (array)JWT::decode($jwt, $key, array('HS256'));
        if ($data['scopes'] == 'role_refresh' && $data['exp'] > time()) {
            // 重新生成Token即可,这个时候refresh_token是有效的
        } else {
            // 可能权限不够或者已经过期,让客户重新登录即可
        }
    }
}