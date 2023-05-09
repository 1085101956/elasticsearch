<?php
namespace app\admin\controller;

use AlibabaCloud\Credentials\Credential\Config;
use AlibabaCloud\SDK\CCC\V20200701\CCC;
use AlibabaCloud\SDK\CCC\V20200701\Models\ListPrivilegesOfUserRequest;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use app\BaseController;
use app\Request;
use Elasticsearch\ClientBuilder;
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

    /**
     * 使用AK&SK初始化账号Client
     * @param string $accessKeyId
     * @param string $accessKeySecret
     * @return CCC Client
     */
    public static function createClient($accessKeyId, $accessKeySecret){
        $config = new Config([
            // 必填，您的 AccessKey ID
            "accessKeyId" => $accessKeyId,
            // 必填，您的 AccessKey Secret
            "accessKeySecret" => $accessKeySecret
        ]);
        // 访问的域名
        $config->endpoint = "ccc.cn-shanghai.aliyuncs.com";
        return new CCC($config);
    }

    /**
     * @param string[] $args
     * @return void
     */
    public function main($args){
        // 工程代码泄露可能会导致AccessKey泄露，并威胁账号下所有资源的安全性。以下代码示例仅供参考，建议使用更安全的 STS 方式，更多鉴权访问方式请参见：https://help.aliyun.com/document_detail/311677.html
        $client = self::createClient("accessKeyId", "accessKeySecret");
        $listPrivilegesOfUserRequest = new ListPrivilegesOfUserRequest([]);
        $runtime = new RuntimeOptions([]);

        try {
            // 复制代码运行请自行打印 API 的返回值
            $client->listPrivilegesOfUserWithOptions($listPrivilegesOfUserRequest, $runtime);
        }
        catch (Exception $error) {

            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }

            // 如有需要，请打印 error
            Utils::assertAsString($error->message);
        }
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