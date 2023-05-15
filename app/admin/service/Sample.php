<?php

namespace app\admin\service;
use AlibabaCloud\SDK\CCC\V20200701\Models\GetInstanceRequest;
use AlibabaCloud\SDK\CCC\V20200701\Models\ListInstancesOfUserRequest;
use AlibabaCloud\SDK\CCC\V20200701\Models\ListInstancesRequest;
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
                $page = ['PageNumber' => $all->data->pageNumber,'PageSize' => $all->data->pageSize,'TotalCount' => $all->data->totalCount];
                $temp = $all->data->toMap();
                return ['page' => $page,'list' => $temp['List']];
            } else {
                return ['code' => 0,'info' => $all->message,'data' => $all->data->list];
            }
        }catch (\Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            Utils::assertAsString($error->message);
        }
    }

    /**
     * @param $page
     * @param $pageSize
     * @return array|void
     * 获取实例列表
     */
    public static function getExampleList($page,$pageSize){
        // 工程代码泄露可能会导致AccessKey泄露，并威胁账号下所有资源的安全性。以下代码示例仅供参考，建议使用更安全的 STS 方式，更多鉴权访问方式请参见：https://help.aliyun.com/document_detail/311677.html
        $client = self::createClient();
        $listInstancesRequest = new ListInstancesRequest([
            "pageNumber" => $page,
            "pageSize" => $pageSize
        ]);
        $runtime = new RuntimeOptions([]);
        try {
            // 复制代码运行请自行打印 API 的返回值
            $list = $client->listInstancesWithOptions($listInstancesRequest, $runtime);
            $all = $list->body;
            if ( $all->code == 'OK') {
                $page = ['PageNumber' => $all->data->pageNumber,'PageSize' => $all->data->pageSize,'TotalCount' => $all->data->totalCount];
                $temp = $all->data->toMap();
                return ['page' => $page,'list' => $temp['List']];
            } else {
                return ['code' => 0,'info' => $all->message,'data' => $all->data->list];
            }
        }
        catch (\Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            // 如有需要，请打印 error
            Utils::assertAsString($error->message);
        }
    }

    /**
     * @param $instanceId
     * @return array|void
     * 获取实例列表详情
     */
    public static function GetInstanceDetails( $instanceId ){
        // 工程代码泄露可能会导致AccessKey泄露，并威胁账号下所有资源的安全性。以下代码示例仅供参考，建议使用更安全的 STS 方式，更多鉴权访问方式请参见：https://help.aliyun.com/document_detail/311677.html
        $client = self::createClient("accessKeyId", "accessKeySecret");
        $getInstanceRequest = new GetInstanceRequest([
            "instanceId" => $instanceId
        ]);
        $runtime = new RuntimeOptions([]);
        try {
            // 复制代码运行请自行打印 API 的返回值
            $list = $client->getInstanceWithOptions($getInstanceRequest, $runtime);
            $all = $list->body;
            if ( $all->code == 'OK') {
                $temp = $all->data->toMap();
                return ['list' => $temp];
            } else {
                return ['code' => 0,'info' => $all->message,'data' => $all->data->list];
            }
        }
        catch (\Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            // 如有需要，请打印 error
            Utils::assertAsString($error->message);
        }
    }


    /**
     * @param string[] $args
     * @return void
     *
     */
    public static function ListInstancesOfUser( $page,$pagesize){
        // 工程代码泄露可能会导致AccessKey泄露，并威胁账号下所有资源的安全性。以下代码示例仅供参考，建议使用更安全的 STS 方式，更多鉴权访问方式请参见：https://help.aliyun.com/document_detail/311677.html
        $client = self::createClient("accessKeyId", "accessKeySecret");
        $listInstancesOfUserRequest = new ListInstancesOfUserRequest([
            "pageNumber" => $page,
            "pageSize" => $pagesize
        ]);
        $runtime = new RuntimeOptions([]);
        try {
            // 复制代码运行请自行打印 API 的返回值
            $list = $client->listInstancesOfUserWithOptions($listInstancesOfUserRequest, $runtime);
            $all = $list->body;
            if ( $all->code == 'OK') {
                $page = ['PageNumber' => $all->data->pageNumber,'PageSize' => $all->data->pageSize,'TotalCount' => $all->data->totalCount];
                $temp = $all->data->toMap();
                return ['page' => $page,'list' => $temp['List']];
            } else {
                return ['code' => 0,'info' => $all->message,'data' => $all->data->list];
            }
        }
        catch (\Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            // 如有需要，请打印 error
            Utils::assertAsString($error->message);
        }
    }
}
