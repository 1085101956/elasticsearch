<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;


Route::get('niha','index/niha');

Route::get("api/seach","index/index");
Route::get("api/create_index","index/createIndex");
Route::get("api/test","index/test");
Route::get("api/get_index","index/getIndex");
Route::get("api/add_index","index/addIndex");

Route::get("api/getyddssd","index/getyddssd");


//链接并绑定socket
Route::get('api/testSocket','index/testSocket');
//个人发送消息
Route::get('api/sendPersonalSocket','index/sendPersonalSocket');
//发送群组消息
Route::get('api/sendGroupSocket','index/sendGroupSocket');