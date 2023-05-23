<?php

namespace app\admin\controller;


use app\BaseController;
use think\log\driver\Socket;
use WebSocket\Client;
use WebSocket\Connection;
use WebSocket\Exception;
use WebSocket\Message\Binary;

class test extends BaseController {
    public function testxx() {

    }

    function processGETRequest($appkey, $token, $text, $audioSaveFile, $format, $sampleRate) {
        $url = "https://nls-gateway-cn-shanghai.aliyuncs.com/stream/v1/tts";
        $url = $url . "?appkey=" . $appkey;
        $url = $url . "&token=" . $token;
        $url = $url . "&text=" . $text;
        $url = $url . "&format=" . $format;
        $url = $url . "&sample_rate=" . strval($sampleRate);
        // voice 发音人，可选，默认是xiaoyun。
        // $url = $url . "&voice=" . "xiaoyun";
        // volume 音量，范围是0~100，可选，默认50。
        // $url = $url . "&volume=" . strval(50);
        // speech_rate 语速，范围是-500~500，可选，默认是0。
        // $url = $url . "&speech_rate=" . strval(0);
        // pitch_rate 语调，范围是-500~500，可选，默认是0。
        // $url = $url . "&pitch_rate=" . strval(0);
        print $url . "\n";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        /**
         * 设置HTTPS GET URL。
         */
        curl_setopt($curl, CURLOPT_URL, $url);
        /**
         * 设置返回的响应包含HTTPS头部信息。
         */
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        /**
         * 发送HTTPS GET请求。
         */
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        $response = curl_exec($curl);
        if ($response == FALSE) {
            print "curl_exec failed!\n";
            curl_close($curl);
            return ;
        }
        /**
         * 处理服务端返回的响应。
         */
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $headers = substr($response, 0, $headerSize);
        $bodyContent = substr($response, $headerSize);
        curl_close($curl);
        if (stripos($headers, "Content-Type: audio/mpeg") != FALSE || stripos($headers, "Content-Type:audio/mpeg") != FALSE) {
            file_put_contents($audioSaveFile, $bodyContent);
            print "The GET request succeed!\n";
        }
        else {
            print "The GET request failed: " . $bodyContent . "\n";
        }
    }
    public function processPOSTRequest() {
        echo '开始时间'.date('Y-m-d H:i:s',time());
        $url = "https://nls-gateway-cn-shanghai.aliyuncs.com/stream/v1/tts";
        $appkey = "";
        $token = "";
        $text = "1.准备工作，安装AS
非常简单，活动安装文件安装，不断的下一步即可。
找到android sdk 命令行安装工具，我使用的是之前下载的24版本，居然还可以使用。
2.安装SDK
把安装工具拷贝到android/sdk/目录下，里面有几个空文件夹和说明，重要的是tools文件夹，打开它，点击里面的android文件，会提示安装一些java的环境和提示下载来源，按照提示解决。
然后，进入工具，会展现对话框，里面有所有可以安装的sdk，选择其中所需，然后点击安装。会有许可证提示，安装所有许可证，然后正常安装即可。
由于，网络环境下载可能需要较长时间。
版权声明：本文为CSDN博主「bobcameltom」的原创文章，遵循CC 4.0 BY-SA版权协议，转载请附上原文出处链接及本声明。
原文链接：https://blog.csdn.net/bobcameltom/article/details/116193946";

        $audioSaveFile = "syAudio.wav";
        $format = "wav";
        $sampleRate = 16000;
        /**
         * 请求参数，以JSON格式字符串填入HTTPS POST请求的Body中。
         */
        $taskArr = array(
            "appkey" => $appkey,
            "token" => $token,
            "text" => $text,
            "format" => $format,
            "sample_rate" => $sampleRate
            // voice 发音人，可选，默认是xiaoyun。
            // "voice" => "xiaoyun",
            // volume 音量，范围是0~100，可选，默认50。
            // "volume" => 50,
            // speech_rate 语速，范围是-500~500，可选，默认是0。
            // "speech_rate" => 0,
            // pitch_rate 语调，范围是-500~500，可选，默认是0。
            // "pitch_rate" => 0
        );
        $body = json_encode($taskArr);
        var_dump($body);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        /**
         * 设置HTTPS POST URL。
         */
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        /**
         * 设置HTTPS POST请求头部。
         * */
        $httpHeaders = array(
            "Content-Type: application/json"
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $httpHeaders);
        /**
         * 设置HTTPS POST请求体。
         */
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        /**
         * 设置返回的响应包含HTTPS头部信息。
         */
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        /**
         * 发送HTTPS POST请求。
         */
        $response = curl_exec($curl);
        if ($response == FALSE) {
            curl_close($curl);
            return ;
        }
        /**
         * 处理服务端返回的响应。
         */
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $headers = substr($response, 0, $headerSize);
        $bodyContent = substr($response, $headerSize);
        curl_close($curl);
        if (stripos($headers, "Content-Type: audio/mpeg") != FALSE || stripos($headers, "Content-Type:audio/mpeg") != FALSE) {
            file_put_contents($audioSaveFile, $bodyContent);
            print "The POST request succeed!\n";
        }
        else {
            print "The POST request failed: " . $bodyContent . "\n";
        }
        echo '结束时间'.date('Y-m-d H:i:s',time());

    }

    public function processPOSTRequests() {
        $client = new WebSocket\Client("ws://echo.websocket.org/");
        $client->text("Hello WebSocket.org!");
        echo $client->receive();
        $client->close();
        $socker = stream_socket_client('ws://nls-gateway.cn-shanghai-internal.aliyuncs.com/ws/v1');

        $client = new WebSocket\Client("ws://echo.websocket.org/");

        echo '开始时间'.date('Y-m-d H:i:s',time());
        $url = "ws://nls-gateway.cn-shanghai-internal.aliyuncs.com/ws/v1";
        $appkey = "";
        $token = "";
        $enable_subtitle = true;
        $text = "众所周知，每年的“燃油车要完日”一共有四天：春天、夏天、秋天和冬天。已经很多年了，只要“燃油车”和“电动车”tag撞一起，某博某音某书上总能一篇篇小作文地毯式炸上三天三夜。在围观群众彻底厌倦此类布朗运动式讨论之前，这还会持续很多年。
尽管这类声音第一次出现可以追溯到远古的沪指5000点，一年、两年、三年……多少年过去，一球样的声音听到耳朵起茧，人们依旧乐此不疲，依旧热泪盈眶，依旧等待着世界哪天魔法突变。
太多人高喊着“正确的废话”，但也许还有人想了解我们到底走到哪儿了、再往前有几条路、都有什么在拦着";

        $audioSaveFile = "syAudio.wav";
        $format = "wav";
        $sampleRate = 16000;
        /**
         * 请求参数，以JSON格式字符串填入HTTPS POST请求的Body中。
         */
        $taskArr = array(
            "appkey" => $appkey,
            "token" => $token,
            "text" => $text,
            "format" => $format,
            "sample_rate" => $sampleRate,
            'enable_subtitle' => $enable_subtitle
            // voice 发音人，可选，默认是xiaoyun。
            // "voice" => "xiaoyun",
            // volume 音量，范围是0~100，可选，默认50。
            // "volume" => 50,
            // speech_rate 语速，范围是-500~500，可选，默认是0。
            // "speech_rate" => 0,
            // pitch_rate 语调，范围是-500~500，可选，默认是0。
            // "pitch_rate" => 0
        );
        $body = json_encode($taskArr);
        var_dump($body);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        /**
         * 设置HTTPS POST URL。
         */
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        /**
         * 设置HTTPS POST请求头部。
         * */
        $httpHeaders = array(
            "Content-Type: application/json"
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $httpHeaders);
        /**
         * 设置HTTPS POST请求体。
         */
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        /**
         * 设置返回的响应包含HTTPS头部信息。
         */
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        /**
         * 发送HTTPS POST请求。
         */
        $response = curl_exec($curl);
        if ($response == FALSE) {
            curl_close($curl);
            return ;
        }
        /**
         * 处理服务端返回的响应。
         */
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $headers = substr($response, 0, $headerSize);
        $bodyContent = substr($response, $headerSize);
        curl_close($curl);
        if (stripos($headers, "Content-Type: audio/mpeg") != FALSE || stripos($headers, "Content-Type:audio/mpeg") != FALSE) {
            file_put_contents($audioSaveFile, $bodyContent);
            print "The POST request succeed!\n";
        }
        else {
            print "The POST request failed: " . $bodyContent . "\n";
        }
        echo '结束时间'.date('Y-m-d H:i:s',time());

    }


}