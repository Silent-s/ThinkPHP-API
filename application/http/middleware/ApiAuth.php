<?php

namespace app\http\middleware;

class ApiAuth
{
    /**
     * 判断Token是否有效和用户状态是否正常
     * @param $request
     * @param \Closure $next
     */
    public function handle($request, \Closure $next)
    {
        // Token是否合法
        // 用户状态是否正常
    }
}
