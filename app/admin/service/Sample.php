<?php

namespace app\admin\service;
use AlibabaCloud\SDK\CCC\V20200701\Models\AddPersonalNumbersToUserRequest;
use AlibabaCloud\SDK\CCC\V20200701\Models\CreateUserRequest;
use AlibabaCloud\SDK\CCC\V20200701\Models\GetInstanceRequest;
use AlibabaCloud\SDK\CCC\V20200701\Models\GetUserRequest;
use AlibabaCloud\SDK\CCC\V20200701\Models\ListDevicesRequest;
use AlibabaCloud\SDK\CCC\V20200701\Models\ListInstancesOfUserRequest;
use AlibabaCloud\SDK\CCC\V20200701\Models\ListInstancesRequest;
use AlibabaCloud\SDK\CCC\V20200701\Models\ListOutboundNumbersOfUserRequest;
use AlibabaCloud\SDK\CCC\V20200701\Models\ListPhoneNumbersRequest;
use AlibabaCloud\SDK\CCC\V20200701\Models\ListRolesRequest;
use AlibabaCloud\SDK\CCC\V20200701\Models\ListUsersRequest;
use AlibabaCloud\SDK\CCC\V20200701\Models\ModifyInstanceRequest;
use AlibabaCloud\SDK\CCC\V20200701\Models\StartPredictiveCallRequest;
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
        $client = self::createClient();
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
        } catch (\Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            // 如有需要，请打印 error
            Utils::assertAsString($error->message);
            return ['code' => 0,'info' => $error->getMessage()];
        }
    }

    /**
     * @param $instanceId
     * @param $description
     * @return array|void
     * 修改云实例备注
     */
    public static function ModifyInstance($instanceId,$description ){
        // 工程代码泄露可能会导致AccessKey泄露，并威胁账号下所有资源的安全性。以下代码示例仅供参考，建议使用更安全的 STS 方式，更多鉴权访问方式请参见：https://help.aliyun.com/document_detail/311677.html
        $client = self::createClient();
        $modifyInstanceRequest = new ModifyInstanceRequest([
            "instanceId" => $instanceId,
            "description" => $description
        ]);
        $runtime = new RuntimeOptions([]);
        try {
            // 复制代码运行请自行打印 API 的返回值
            $list = $client->modifyInstanceWithOptions($modifyInstanceRequest, $runtime);
            $all = $list->body;
            if ( $all->code == 'OK') {
                return [];
            } else {
                return ['code' => 0,'info' => $all->message,'data' => []];
            }
        }
        catch (\Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            // 如有需要，请打印 error
            Utils::assertAsString($error->message);
            return ['code' => 0,'info' => $error->getMessage()];
        }
    }

    /**
     * @param $InstanceId
     * @param $UserId
     * @param $NumberList
     * @return array
     * 添加一个或多个个人外呼号码到指定实例下的指定坐席
     */
    public static function AddPersonalNumbersToUser($InstanceId,$UserId,$NumberList) {
        $client = self::createClient();
        $addPersonalNumbersToUserRequest = new AddPersonalNumbersToUserRequest([
            "instanceId" => $InstanceId,
            "userId" => $UserId,//"likenong520@126.com@demo-1551701848918487",
            "numberList" => $NumberList,//"['18225120509']"
        ]);
        $runtime = new RuntimeOptions([]);
        try {
            // 复制代码运行请自行打印 API 的返回值
            $list = $client->addPersonalNumbersToUserWithOptions($addPersonalNumbersToUserRequest, $runtime);
            $all = $list->body;
            if ( $all->code == 'OK') {
                return ['list' => $all->data];
            } else {
                return ['code' => 0,'info' => $all->message,'data' => []];
            }
        }
        catch (\Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            // 如有需要，请打印 error
            Utils::assertAsString($error->message);
            return ['code' => 0,'info' => $error->getMessage()];
        }
    }

    /**
     * @param $InstanceId
     * @param $page
     * @param $PageSize
     * @return array
     * 获取坐席列表
     */
    public static function ListUsersOAuth($InstanceId,$page,$PageSize){
        // 工程代码泄露可能会导致AccessKey泄露，并威胁账号下所有资源的安全性。以下代码示例仅供参考，建议使用更安全的 STS 方式，更多鉴权访问方式请参见：https://help.aliyun.com/document_detail/311677.html
        $client = self::createClient();
        $listUsersRequest = new ListUsersRequest([
            "instanceId" => $InstanceId,
            "pageNumber" => $page,
            "pageSize" => $PageSize
        ]);
        $runtime = new RuntimeOptions([]);
        try {
            // 复制代码运行请自行打印 API 的返回值
            $list = $client->listUsersWithOptions($listUsersRequest, $runtime);
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
            return ['code' => 0,'info' => $error->getMessage()];
        }
    }

    /**
     * @param $InstanceId
     * @param $UserId
     * @param $PageNumber
     * @param $PageSize
     * 获取指定实例下指定坐席的可外呼号码
     */
    public static function ListOutboundNumbersOfUser($InstanceId,$UserId,$PageNumber,$PageSize){
        $client = self::createClient();
        $listOutboundNumbersOfUserRequest = new ListOutboundNumbersOfUserRequest([
            "instanceId" => $InstanceId,
            "userId" => $UserId,
            "pageNumber" => $PageNumber,
            "pageSize" => $PageSize
        ]);
        $runtime = new RuntimeOptions([]);
        try {
            // 复制代码运行请自行打印 API 的返回值
            $list = $client->listOutboundNumbersOfUserWithOptions($listOutboundNumbersOfUserRequest, $runtime);
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
            return ['code' => 0,'info' => $error->getMessage()];
        }
    }

    /**
     * @param $InstanceId
     * @param $PageNumber
     * @param $PageSize
     * @return array|void
     * 获取指定实例下的号码列表
     */
    public static function ListPhoneNumbers($InstanceId,$PageNumber,$PageSize){
        $client = self::createClient();
        $listPhoneNumbersRequest = new ListPhoneNumbersRequest([
            "instanceId" => $InstanceId,
            "pageNumber" => $PageNumber,
            "pageSize" => $PageSize
        ]);
        $runtime = new RuntimeOptions([]);
        try {
            // 复制代码运行请自行打印 API 的返回值
            $list = $client->listPhoneNumbersWithOptions($listPhoneNumbersRequest, $runtime);
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
            return ['code' => 0,'info' => $error->getMessage()];

        }
    }

    /**
     * @param $InstanceId
     * @return array|void
     * 获取坐席列表
     */
    public static function ListRoles($InstanceId){
        // 工程代码泄露可能会导致AccessKey泄露，并威胁账号下所有资源的安全性。以下代码示例仅供参考，建议使用更安全的 STS 方式，更多鉴权访问方式请参见：https://help.aliyun.com/document_detail/311677.html
        $client = self::createClient();
        $listRolesRequest = new ListRolesRequest([
            "instanceId" => $InstanceId
        ]);
        $runtime = new RuntimeOptions([]);
        try {
            // 复制代码运行请自行打印 API 的返回值
            $list = $client->listRolesWithOptions($listRolesRequest, $runtime);
            $all = $list->body;
            if ( $all->code == 'OK') {
                $temp = $all->toMap();
                return ['list' => $temp['Data']];
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
            return ['code' => 0,'info' => $error->getMessage()];

        }
    }

    /**
     * @param $InstanceId
     * @param $LoginName
     * @param $DisplayName
     * @param $Mobile
     * @param $Email
     * @param $WorkMode
     * @param $RoleId
     * @return array
     * 创建坐席
     */
    public static function CreateUser($InstanceId,$LoginName,$DisplayName,$Mobile,$Email,$WorkMode,$RoleId){
        $client = self::createClient();
        $createUserRequest = new CreateUserRequest([
            "email" => $Email,
            "workMode" => $WorkMode,
            "displayName" => $DisplayName,
            "loginName" => $LoginName,
            "instanceId" => $InstanceId,
            "roleId" => $RoleId,
            "mobile" => $Mobile
        ]);
        $runtime = new RuntimeOptions([]);
        try {
            // 复制代码运行请自行打印 API 的返回值
            $list = $client->createUserWithOptions($createUserRequest, $runtime);
            $all = $list->body;
            if ( $all->code == 'OK') {
                return ['list' => $all->data];
            } else {
                return ['code' => 0,'info' => $all->message,'data' => []];
            }
        }
        catch (\Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            // 如有需要，请打印 error
            Utils::assertAsString($error->message);
            return ['code' => 0,'info' => $error->getMessage()];

        }
    }

    /**
     * @param $InstanceId
     * @param $UserId
     * @return array
     * 创建坐席
     */
    public static function GetUser($InstanceId,$UserId){
        $client = self::createClient();
        $getUserRequest = new GetUserRequest([
            "instanceId" => $InstanceId,
            "userId" => $UserId
        ]);
        $runtime = new RuntimeOptions([]);
        try {
            // 复制代码运行请自行打印 API 的返回值
            $list = $client->getUserWithOptions($getUserRequest, $runtime);
            $all = $list->body;
            if ( $all->code == 'OK') {
                return ['list' => $all->data];
            } else {
                return ['code' => 0,'info' => $all->message,'data' => []];
            }
        }
        catch (\Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            // 如有需要，请打印 error
            Utils::assertAsString($error->message);
            return ['code' => 0,'info' => $error->getMessage()];
        }
    }

    /**
     * @param $InstanceId
     * @param $UserId
     * @return array
     * 获取指定实例下指定坐席的设备列表
     */
    public static function ListDevices($InstanceId,$UserId){
        // 工程代码泄露可能会导致AccessKey泄露，并威胁账号下所有资源的安全性。以下代码示例仅供参考，建议使用更安全的 STS 方式，更多鉴权访问方式请参见：https://help.aliyun.com/document_detail/311677.html
        $client = self::createClient("accessKeyId", "accessKeySecret");
        $listDevicesRequest = new ListDevicesRequest([
            "instanceId" => $InstanceId,
            "userId" => $UserId
        ]);
        $runtime = new RuntimeOptions([]);
        try {
            // 复制代码运行请自行打印 API 的返回值
            $list = $client->listDevicesWithOptions($listDevicesRequest, $runtime);
            $all = $list->body;
            if ( $all->code == 'OK') {
                return ['list' => $all->data];
            } else {
                return ['code' => 0,'info' => $all->message,'data' => []];
            }
        }
        catch (\Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            // 如有需要，请打印 error
            Utils::assertAsString($error->message);
            return ['code' => 0,'info' => $error->getMessage()];
        }
    }

    /**
     * @param $InstanceId
     * @param $Caller
     * @param $Callee
     * @param $ContactFlowId
     * @return array
     * 发起预测式外呼
     */
    public static function StartPredictiveCall($InstanceId,$Caller,$Callee,$ContactFlowId){
        // 工程代码泄露可能会导致AccessKey泄露，并威胁账号下所有资源的安全性。以下代码示例仅供参考，建议使用更安全的 STS 方式，更多鉴权访问方式请参见：https://help.aliyun.com/document_detail/311677.html
        $client = self::createClient();
        $startPredictiveCallRequest = new StartPredictiveCallRequest([
            "instanceId" => $InstanceId,
            "caller" => $Caller,
            "callee" => $Callee,
            "contactFlowId" => $ContactFlowId
        ]);
        $runtime = new RuntimeOptions([]);
        try {
            // 复制代码运行请自行打印 API 的返回值
            $list = $client->startPredictiveCallWithOptions($startPredictiveCallRequest, $runtime);
            $all = $list->body;
            if ( $all->code == 'OK') {
                return ['list' => $all->data];
            } else {
                return ['code' => 0,'info' => $all->message,'data' => []];
            }
        }
        catch (\Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            // 如有需要，请打印 error
            Utils::assertAsString($error->message);
            return ['code' => 0,'info' => $error->getMessage()];
        }
    }
}
