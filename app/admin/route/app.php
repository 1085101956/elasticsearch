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
Route::get("api/test_xx","index/test_xx");
Route::get("api/test_x","index/test_x");
Route::get("api/test_xxx","index/test_xxx");
Route::get("api/ModifyInstance","index/ModifyInstance");//修改实力
Route::get("api/AddPersonalNumbersToUser","index/AddPersonalNumbersToUser");//修改实力
Route::get("api/ListUsersOAuth","index/ListUsersOAuth");//修改实力
Route::get("api/ListOutboundNumbersOfUser","index/ListOutboundNumbersOfUser");//修改实力
Route::get("api/ListPhoneNumbers","index/ListPhoneNumbers");//修改实力
Route::get("api/ListRoles","index/ListRoles");//修改实力
Route::get("api/CreateUser","index/CreateUser");//修改实力




//链接并绑定socket
Route::get('api/testSocket','index/testSocket');
//个人发送消息
Route::get('api/sendPersonalSocket','index/sendPersonalSocket');
//发送群组消息
Route::get('api/sendGroupSocket','index/sendGroupSocket');