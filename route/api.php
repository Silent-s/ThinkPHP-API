<?php

use think\facade\Route;
Route::get('api/:version/test','api/:version.Test/test');
Route::get('api/:version/test1','api/:version.Test/test2');
// 用户注册
Route::post('api/:version/users','api/:version.Users/store');
// 用户登录
// 短信登陆
// 用户信息
// 编辑用户信息
// 主页轮播图接口
// APP启动页面接口
// 用户反馈
// 分类列表
// 发布话题
// 话题列表
// 话题详情
// 回复
// 用户回复点赞接口
// 获取话题回复列表
// 消息推送