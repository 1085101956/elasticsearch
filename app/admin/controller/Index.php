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
            'index' => 'blog',
            'client' => [
                'ignore' => 404
            ]
        ];

        $list = $client->indices()->getSettings($params);
        var_dump( $list );
    }
    public function addMapping() {
        $params = [
            'index' => 'blog',//索引 （相当于mysql的数据库）
            'body'  => [
                'mappings' => [
                    'base_article' => [ //类型名（相当于mysql的表）
                        '_all'=>[   //  是否开启所有字段的检索
                            'enabled' => 'false'
                        ],
                        'properties' => [ //文档类型设置（相当于mysql的数据类型）
                            'id'    => [
                                'type' => 'integer' // 字段类型为整型
                            ],
                            'first_letter' => [
                                'type' => 'keyword'
                            ],
                            'name'  => [
                                'type'  => 'keyword',
                            ],
                            'create_at' => [
                                'type'  => 'keyword'
                            ],
                            ''
                        ]
                    ]
                ]
            ]
        ];
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