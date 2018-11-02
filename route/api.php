<?php

use think\facade\Route;

Route::post('api/:version/user/login', 'api/:version.User/login');
Route::get('api/:version/test', 'api/:version.Tests/test');