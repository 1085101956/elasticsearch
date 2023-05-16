<?php
namespace app\controller;

use app\BaseController;
use GatewayClient\Gateway;

class Index extends BaseController
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V' . \think\facade\App::version() . '<br/><span style="font-size:30px;">16载初心不改 - 你值得信赖的PHP框架</span></p><span style="font-size:25px;">[ V6.0 版本由 <a href="https://www.yisu.com/" target="yisu">亿速云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ee9b1aa918103c4fc"></think>';
    }




    public function hello($name = 'ThinkPHP6')
    {
        echo 566;
        return 'hello,' . $name;

    }
    public function niha() {
        return '5dadsadsa';
    }

    public function TestSocket() {
        Gateway::$registerAddress = '127.0.0.1:1238';
        // 假设用户已经登录，用户uid和群组id在session中

        $uid = $_GET['uid'];
        $group_id = $_GET['group_id'];
        $client_id = $_GET['client_id'];
        // client_id与uid绑定
        Gateway::bindUid($client_id, $uid);
        // 加入某个群组（可调用多次加入多个群组）
        Gateway::joinGroup($client_id, $group_id);
    }

    public function sendPersonalSocket() {
        $uid = $_GET['uid'];
        $message = $_GET['message'];
        Gateway::sendToUid($uid, json_encode( ['type' => 1,'msg' => $message]));
    }

    public function sendGroupSocket() {
        $group_id = $_GET['group_id'];
        $message = $_GET['message'];
        Gateway::sendToGroup($group_id, json_encode( ['type' => 2,'msg' => $message]));
    }

}
