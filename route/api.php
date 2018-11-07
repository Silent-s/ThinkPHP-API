<?php

use think\facade\Route;

// 用户登录(获取Token)
Route::post('api/:version/token', 'api/:version.Token/getToken');
// 用户保持登录(刷新Token)
Route::post('api/:version/refresh_token', 'api/:version.Token/refreshToken');

// 用户注册
//Route::post('api/:version/users', 'api/:version.Users/getUserInfo');
// 获取用户信息
Route::get('api/:version/user', 'api/:version.Users/getUserInfo');
// 修改用户昵称
Route::put('api/:version/user/username', 'api/:version.Users/editUsername');
// 修改用户密码
Route::put('api/:version/user/password', 'api/:version/editPassword');
// 修改用户头像
Route::put('api/:version/user/head_portrait', 'api/:version/editHeadPortrait');
// 修改生日
Route::put('api/:version/user/birthday', 'api/:version/editBirthday');
// 修改介绍
Route::put('api/:version/user/introduce', 'api/:version/editIintroduce');
// 修改地址
Route::put('api/:version/user/address', 'api/:version/editAddress');


// 增加用户地址
Route::post('api/:version/address', 'api/:version.Address/addUserAddress');
// 修改用户地址
Route::put('api/:version/address', 'api/:version.Address/editUserAddress');
// 获取用户地址列表
Route::get('api/:version/address', 'api/:version.Address/getUserAddress');
// 获取用户某个地址信息
Route::get('api/:version/address/:id', 'api/:version.Address/getUserAddressOne');
// 删除用户某个地址(单条删除)
Route::delete('api/:version/address/:id', 'api/:version.Address/deleteUserAddressOne');

// 单图上传
Route::post('api/:version/file', 'api/:version.Upload/addUserAddress');
// 多图上传
Route::post('api/:version/files', 'api/:version.Upload/addaddress');

