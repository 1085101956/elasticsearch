<?php
namespace app\admin\controller;

use app\BaseController;
use app\Request;
use Elasticsearch\ClientBuilder;
use think\facade\Db;


class Index extends BaseController {

    public function index (Request $request) {
        $client = ClientBuilder::create()
            ->setHosts(['localhost:9200'])
            ->build();
        $response = $client->info();
        // 响应格式化
        $params = [
            'index' => 'myblog',
            'client' => [
                'ignore' => 404
            ]
        ];

        $list = $client->indices()->getSettings($params);
        var_dump( $list );


    }
    public function createIndex () {
        echo 4554;
        $list = Db::name('demands_cate')->field('id,name,cover')->select();
        var_dump($list);
    }
    public function test() {
        phpinfo();
    }
}