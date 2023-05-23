<?php
namespace app\admin\controller;

use AlibabaCloud\Credentials\Credential\Config;
use AlibabaCloud\SDK\CCC\V20200701\CCC;
use AlibabaCloud\SDK\CCC\V20200701\Models\ListPrivilegesOfUserRequest;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use app\admin\service\Sample;
use app\BaseController;
use app\Request;
use Elasticsearch\ClientBuilder;
use think\Collection;
use think\Exception;
use think\facade\Db;
use think\facade\View;


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
        $a = "大小:10kg,20kg,15kg";
        $b = "种类:黑猪,白猪,野猪";
        $c = "质量:A,B,C,D";
        $d = "平直量:100,200,400,600";
        $kind1 = explode(":",$a);
        $kind2 = explode(":",$b);
        $kind3 = explode(":",$c);
        $kind4 = explode(":",$d);

        $store_goods_spec_class = ['5' => '型号', '类型','重量','个头', '大小', '口味', '含净量', '款式', '种类', '包装',
            '数量', '自定义', '数量', 'xixi', '新鲜的程度', 'das', 'zd', '产地', '等级', '只装', '包冰量', '单袋重量',
            '单个大小', '单袋重量', '单个大小', '小虾米'];

        $data = [
            explode(",",end($kind1)),
            explode(",",end($kind2)),
            explode(",",end($kind3)),
            explode(",",end($kind4)),
        ];
        var_dump($data);
        $p = $this->makeUp($data);
        var_dump($p);

    }
    public function makeUp($data) {
        $len = count($data);

        for ( $i = 0; $i < $len; $i ++ ){
            if ( $i === 0 ) {
                $result = $data[$i];
                continue;
            }
            $temp = [];
            foreach ( $result as  $v ) {
                foreach ( $data[$i] as  $value ) {
                    $temp[] = $v.'|'.$value;
                }
                $result = $temp;
            }
        }
        return $result;
    }

    public function getyddssd() {
        $list = Sample::getContactFlowList(1,20,'demo-1551701848918487');
        if ( empty($list['message']) ) {
            $this->success('成功',$list);
        }
        $this->error('失败',$list);
    }
    public function test_xx() {
        $list = Sample::getExampleList(1,20);
        if ( empty($list['message']) ) {
            $this->success('成功',$list);
        }
        $this->error('失败',$list);
    }
    public function test_x() {
        $list = Sample::GetInstanceDetails('demo-1551701848918487');
        if ( empty($list['message']) ) {
            $this->success('成功',$list);
        }
        $this->error('失败',$list);
    }
    public function test_xxx() {
        $list = Sample::ListInstancesOfUser(1,20);
        if ( empty($list['message']) && !isset($list['code']) ) {
            $this->success('成功',$list);
        }
        $this->error('失败',$list);
    }
    public function ModifyInstance() {
        $list = Sample::ModifyInstance('demo-1551701848918487','修改内容');
        if ( empty($list['message']) && !isset($list['code']) ) {
            $this->success('成功',$list);
        }
        $this->error('失败',$list);
    }
    public function AddPersonalNumbersToUser() {
        $list = Sample::AddPersonalNumbersToUser('demo-1551701848918487','likenong520@126.com@demo-1551701848918487',"['18225120509']");
        if ( empty($list['message']) && !isset($list['code']) ) {
            $this->success('成功',$list);
        }
        $this->error('失败',$list);
    }
    public function ListUsersOAuth() {
        $list = Sample::ListUsersOAuth('demo-1551701848918487',1,20);
        if ( empty($list['message']) && !isset($list['code']) ) {
            $this->success('成功',$list);
        }
        $this->error('失败',$list);
    }
    public function ListOutboundNumbersOfUser() {
        $list = Sample::ListOutboundNumbersOfUser('demo-1551701848918487','likenong520@126.com@demo-1551701848918487',1,20);
        if ( empty($list['message']) && !isset($list['code']) ) {
            $this->success('成功',$list);
        }
        $this->error('失败',$list);
    }
    public function ListPhoneNumbers () {
        $list = Sample::ListPhoneNumbers('demo-1551701848918487',1,20);
        if ( empty($list['message']) && !isset($list['code']) ) {
            $this->success('成功',$list);
        }
        $this->error('失败',$list);
    }
    public function ListRoles() {
        $list = Sample::ListRoles('demo-1551701848918487');
        if ( empty($list['message']) && !isset($list['code']) ) {
            $this->success('成功',$list);
        }
        $this->error('失败',$list);
    }
    public function CreateUser() {
        $list = Sample::CreateUser('demo-1551701848918487','agent','坐席小王','18225120509','username@example.com','ON_SITE','Agent@demo-1551701848918487');
        if ( empty($list['message']) && !isset($list['code']) ) {
            $this->success('成功',$list);
        }
        $this->error('失败',$list);
    }
    public function GetUser() {
        $list = Sample::GetUser('demo-1551701848918487','likenong520@126.com@demo-1551701848918487');
        if ( empty($list['message']) && !isset($list['code']) ) {
            $this->success('成功',$list);
        }
        $this->error('失败',$list);
    }
    public function ListDevices() {
        $list = Sample::ListDevices('demo-1551701848918487','likenong520@126.com@demo-1551701848918487');
        if ( empty($list['message']) && !isset($list['code']) ) {
            $this->success('成功',$list);
        }
        $this->error('失败',$list);
    }
    public function StartPredictiveCall() {
        $list = Sample::StartPredictiveCall('demo-1551701848918487','6690228519628306','19936016718','cea968b5-e8a6-45ac-b17c-1049dc77d67b');
        if ( empty($list['message']) && !isset($list['code']) ) {
            $this->success('成功',$list);
        }
        $this->error('失败',$list);

    }
    public function getIndex()
    {
        return View::fetch('index');
    }

    public function addIndex()
    {
        return View::fetch('add');
    }


}