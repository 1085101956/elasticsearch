<?php

namespace app\admin\service;
use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\CCC\V20200701\CCC;
use AlibabaCloud\SDK\CCC\V20200701\Models\ListContactFlowsRequest;
use AlibabaCloud\Tea\Utils\Utils;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use AlibabaCloud\Tea\Exception\TeaError;

use think\App;
use think\Service;

class Sample extends Service
{
    /**
     * 使用AK&SK初始化账号Client
     * @param string $accessKeyId
     * @param string $accessKeySecret
     * @return CCC Client
     */
    public static function createClient(){
        $config = new Config([
            // 必填，您的 AccessKey ID
            "accessKeyId" => '',
            // 必填，您的 AccessKey Secret
            "accessKeySecret" => '',
        ]);
        // 访问的域名
        $config->endpoint = "ccc.cn-shanghai.aliyuncs.com";
        return new CCC($config);
    }


    /**
     * @param $page
     * @param $pageSize
     * @param $instanceId
     * @return array|void
     * 获取联系流列表
     */
    public static function getContactFlowList($page,$pageSize,$instanceId){
        $client = self::createClient();
        $listContactFlowsRequest = new ListContactFlowsRequest([
            "instanceId" => "demo-1551701848918487",//$instanceId
            "pageNumber" => $page,
            "pageSize" => $pageSize
        ]);
        $runtime = new RuntimeOptions([]);
        try {
            $list = $client->listContactFlowsWithOptions($listContactFlowsRequest, $runtime);
            $all = $list->body;
            if ( $all->code == 'OK') {
                return ['code' => 0,'msg' => '获取成功','data' => $all->data->list];
            } else {
                return ['code' => 1,'msg' => $all->message,'data' => $all->data->list];
            }
        }catch (\Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            Utils::assertAsString($error->message);
        }

    }

    /**
     * @param $obj
     *
     */
    public static function object_to_array( $obj ) {
        $arr = (array)$obj;
        foreach ( $arr as $k => $v ) {
            if ( gettype($v) == 'resource') {
                return ;
            }
            if ( gettype($v) == 'object' || gettype($v) == 'array') {
                $arr[$k] = (array)self::object_to_array($v);
            }
        }
    }
}
