<?php
/**
 * Created by PhpStorm.
 * User: ALan-繁华
 * Email:251956250@qq.com
 * Date: 2018/8/14
 * Time: 10:41
 * Use : 易联云打印机封装类
 */

namespace printer;


class Printer
{
    //获取acccee_token接口
    private static $requestUrl = 'https://open-api.10ss.net/oauth/oauth';

    //打印机接口API根URL
    private static $baseRequestUrl = 'https://open-api.10ss.net';

    public function __construct()
    {
        $this->client_id    = config('app.print.client_id');
        $this->client_secret    = config('app.print.client_secret');
    }

    /**
     * 自有应用模式下的授权终端,扫码绑定请把msign参数改成qr_key
     * @param $machineCode          易联云打印机终端号
     * @param $msign or $qrKey      特殊密钥(有效期为300秒)
     * @param $accessToken
     * @param $timesTamp
     * @return mixed
     */
    public function addPrint($machineCode, $msign, $accessToken)
    {
        $requestUrl = self::$baseRequestUrl.'/printer/addprinter';
        $requestAll = [
            'client_id' => $this->client_id,
            'sign' => $this->GetSign(),
            'id' => $this->Uuid4(),
            'machine_code' => $machineCode,
            'msign' => $msign,
            'access_token' => $accessToken,
            'timestamp' => time(),
        ];
        $requestInfo = http_build_query($requestAll);
        return $this->push($requestInfo,$requestUrl);
    }

    /**
     * 打印接口
     * @param $machineCode
     * @param $accessToken
     * @param $content
     * @param $originId
     * @param $timesTamp
     * @return mixed
     */
    public function printIndex($machineCode, $accessToken, $content, $originId)
    {
        $requestUrl = self::$baseRequestUrl.'/print/index';
        $requestAll = [
            'client_id' => $this->client_id,
            'sign' => $this->GetSign(),
            'id' => $this->Uuid4(),
            'machine_code' => $machineCode,
            'access_token' => $accessToken,
            'content' => $content,
            'origin_id' => $originId,
            'timestamp' => time(),
        ];
        $requestInfo = http_build_query($requestAll);
        return $this->push($requestInfo,$requestUrl);
    }

    /**
     * 删除终端授权
     * @param $machineCode
     * @param $accessToken
     * @param $timesTamp
     * @return mixed
     */
    public function deletePrint($machineCode, $accessToken)
    {
        $requestUrl = self::$baseRequestUrl.'/printer/deleteprinter';
        $requestAll = [
            'client_id' => $this->client_id,
            'sign' => $this->GetSign(),
            'id' => $this->Uuid4(),
            'machine_code' => $machineCode,
            'access_token' => $accessToken,
            'timestamp' => time(),
        ];
        $requestInfo = http_build_query($requestAll);
        return $this->push($requestInfo,$requestUrl);
    }

    /**
     * 设置应用菜单接口
     * @param $machineCode
     * @param $accessToken
     * @param $content
     * @param $timesTamp
     * @return mixed
     */
    public function printMenu($machineCode, $accessToken, $content)
    {
        $requestUrl = self::$baseRequestUrl.'/printmenu/addprintmenu';
        $requestAll = [
            'client_id' => $this->client_id,
            'sign' => $this->GetSign(),
            'id' => $this->Uuid4(),
            'machine_code' => $machineCode,
            'access_token' => $accessToken,
            'content' => $content,
            'timestamp' => time(),
        ];
        $requestInfo = http_build_query($requestAll);
        return $this->push($requestInfo,$requestUrl);
    }

    /**
     * 关机重启接口
     * @param $machineCode
     * @param $accessToken
     * @param $responseType
     * @param $timesTamp
     * @return mixed
     */
    public function shutdownRestart($machineCode, $accessToken, $responseType)
    {
        $requestUrl = self::$baseRequestUrl.'/printer/shutdownrestart';
        $requestAll = [
            'client_id' => $this->client_id,
            'sign' => $this->GetSign(),
            'id' => $this->Uuid4(),
            'machine_code' => $machineCode,
            'access_token' => $accessToken,
            'response_type' => $responseType,
            'timestamp' => time(),
        ];
        $requestInfo = http_build_query($requestAll);
        return $this->push($requestInfo,$requestUrl);
    }

    /**
     * 声音调节接口
     * @param $machineCode
     * @param $accessToken
     * @param $responseType
     * @param $voice
     * @param $timesTamp
     * @return mixed
     */
    public function setSound($machineCode, $accessToken, $responseType, $voice)
    {
        $requestUrl = self::$baseRequestUrl.'/printer/setsound';
        $requestAll = [
            'client_id' => $this->client_id,
            'sign' => $this->GetSign(),
            'id' => $this->Uuid4(),
            'machine_code' => $machineCode,
            'access_token' => $accessToken,
            'response_type' => $responseType,
            'voice' => $voice,
            'timestamp' => time(),
        ];
        $requestInfo = http_build_query($requestAll);
        return $this->push($requestInfo,$requestUrl);
    }

    /**
     * 设置内置语音接口
     * @param $machineCode
     * @param $accessToken
     * @param $responseType
     * @param $voice
     * @param $timesTamp
     * @return mixed
     */
    public function setVoice($machineCode, $accessToken, $content)
    {
        $requestUrl = self::$baseRequestUrl.'/printer/setvoice';
        $requestAll = [
            'client_id' => $this->client_id,
            'sign' => $this->GetSign(),
            'id' => $this->Uuid4(),
            'machine_code' => $machineCode,
            'access_token' => $accessToken,
            'content' => $content,
            'timestamp' => time(),
        ];

        $requestInfo = http_build_query($requestAll);
        return $this->push($requestInfo,$requestUrl);
    }

    /**
     * 删除内置语音接口
     * @param $machineCode
     * @param $accessToken
     * @param $responseType
     * @param $voice
     * @param $timesTamp
     * @return mixed
     */
    public function deleteVoice($machineCode, $accessToken, $aid)
    {
        $requestUrl = self::$baseRequestUrl.'/printer/deletevoice';
        $requestAll = [
            'client_id' => $this->client_id,
            'sign' => $this->GetSign(),
            'id' => $this->Uuid4(),
            'machine_code' => $machineCode,
            'access_token' => $accessToken,
            'aid' => $aid,
            'timestamp' => time(),
        ];

        $requestInfo = http_build_query($requestAll);
        return $this->push($requestInfo,$requestUrl);
    }


    /**
     * 获取机型打印宽度接口
     * @param $machineCode
     * @param $accessToken
     * @param $timesTamp
     * @return mixed
     */
    public function printInfo($machineCode, $accessToken)
    {
        $requestUrl = self::$baseRequestUrl.'/printer/printinfo';
        $requestAll = [
            'client_id' => $this->client_id,
            'sign' => $this->GetSign(),
            'id' => $this->Uuid4(),
            'machine_code' => $machineCode,
            'access_token' => $accessToken,
            'timestamp' => time(),
        ];
        $requestInfo = http_build_query($requestAll);
        return $this->push($requestInfo,$requestUrl);
    }


    /**
     *获取机型软硬件版本接口
     * @param $machineCode
     * @param $accessToken
     * @param $timesTamp
     * @return mixed
     */
    public function getVersion($machineCode, $accessToken)
    {
        $requestUrl = self::$baseRequestUrl.'/printer/getversion';
        $requestAll = [
            'client_id' => $this->client_id,
            'sign' => $this->GetSign(),
            'id' => $this->Uuid4(),
            'machine_code' => $machineCode,
            'access_token' => $accessToken,
            'timestamp' => time(),
        ];
        $requestInfo = http_build_query($requestAll);
        return $this->push($requestInfo,$requestUrl);
    }

    /**
     * 取消所有未打印接口
     * @param $machineCode
     * @param $accessToken
     * @param $timesTamp
     * @return mixed
     */
    public function cancelAll($machineCode, $accessToken)
    {
        $requestUrl = self::$baseRequestUrl.'/printer/cancelall';
        $requestAll = [
            'client_id' => $this->client_id,
            'sign' => $this->GetSign(),
            'id' => $this->Uuid4(),
            'machine_code' => $machineCode,
            'access_token' => $accessToken,
            'timestamp' => time(),
        ];
        $requestInfo = http_build_query($requestAll);
        return $this->push($requestInfo,$requestUrl);
    }

    /**
     * 取消单条未打印订单接口
     * @param $machineCode
     * @param $accessToken
     * @param $orderId
     * @param $timesTamp
     * @return mixed
     */
    public function cancelOne($machineCode, $accessToken, $orderId)
    {
        $requestUrl = self::$baseRequestUrl.'/printer/cancelone';
        $requestAll = [
            'client_id' => $this->client_id,
            'sign' => $this->GetSign(),
            'id' => $this->Uuid4(),
            'machine_code' => $machineCode,
            'access_token' => $accessToken,
            'order_id' => $orderId,
            'timestamp' => time(),
        ];
        $requestInfo = http_build_query($requestAll);
        return $this->push($requestInfo,$requestUrl);
    }

    /**
     * 设置logo接口
     * @param $machineCode
     * @param $accessToken
     * @param $imgUrl
     * @param $timesTamp
     * @return mixed
     */
    public function setIcon($machineCode, $accessToken, $imgUrl)
    {
        $requestUrl = self::$baseRequestUrl.'/printer/seticon';
        $requestAll = [
            'client_id' => $this->client_id,
            'sign' => $this->GetSign(),
            'id' => $this->Uuid4(),
            'machine_code' => $machineCode,
            'access_token' => $accessToken,
            'img_url' => $imgUrl,
            'timestamp' => time(),
        ];
        $requestInfo = http_build_query($requestAll);
        return $this->push($requestInfo,$requestUrl);
    }

    /**
     * 取消logo接口
     * @param $machineCode
     * @param $accessToken
     * @param $timesTamp
     * @return mixed
     */
    public function deleteIcon($machineCode, $accessToken)
    {
        $requestUrl = self::$baseRequestUrl.'/printer/deleteicon';
        $requestAll = [
            'client_id' => $this->client_id,
            'sign' => $this->GetSign(),
            'id' => $this->Uuid4(),
            'machine_code' => $machineCode,
            'access_token' => $accessToken,
            'timestamp' => time(),
        ];
        $requestInfo = http_build_query($requestAll);
        return $this->push($requestInfo,$requestUrl);
    }

    /**
     * 按键打印接口
     * @param $machineCode
     * @param $accessToken
     * @param $responseType
     * @param $timesTamp
     * @return mixed
     */
    public function btnPrint($machineCode, $accessToken, $responseType)
    {
        $requestUrl = self::$baseRequestUrl.'/printer/btnprint';
        $requestAll = [
            'client_id' => $this->client_id,
            'sign' => $this->GetSign(),
            'id' => $this->Uuid4(),
            'machine_code' => $machineCode,
            'access_token' => $accessToken,
            'response_type' => $responseType,
            'timestamp' => time(),
        ];
        $requestInfo = http_build_query($requestAll);
        return $this->push($requestInfo,$requestUrl);
    }

    /**
     * 接单拒单接口
     * @param $machineCode
     * @param $accessToken
     * @param $responseType
     * @param $timesTamp
     * @return mixed
     */
    public function getOrder($machineCode, $accessToken, $responseType)
    {
        $requestUrl = self::$baseRequestUrl.'/printer/getorder';
        $requestAll = [
            'client_id' => $this->client_id,
            'sign' => $this->GetSign(),
            'id' => $this->Uuid4(),
            'machine_code' => $machineCode,
            'access_token' => $accessToken,
            'response_type' => $responseType,
            'timestamp' => time(),
        ];
        $requestInfo = http_build_query($requestAll);
        return $this->push($requestInfo,$requestUrl);
    }


    /**
     * 获取Token
     * @param $grantType
     * @param $scope
     * @param $timesTamp
     * @param null $code
     * @return mixed
     */
    public function GetToken( $scope = 'all',  $code = null)
    {
        $requestAll = [
            'client_id' => $this->client_id,
            'sign' => $this->GetSign(),
            'id' => $this->Uuid4(),
            'grant_type' => 'client_credentials',
            'scope' => $scope,
            'code' => $code,
            'timestamp' => time(),
        ];
        $requestInfo = http_build_query($requestAll);

        return $this->push($requestInfo, self::$requestUrl);
    }

    /**
     * 刷新Token
     * @param $grantType
     * @param $scope
     * @param $timesTamp
     * @param $RefreshToken
     * @return mixed
     */
    public function RefreshToken($scope = 'all',  $RefreshToken)
    {
        $requestAll = [
            'client_id' => $this->client_id,
            'sign' => $this->GetSign(),
            'id' => $this->Uuid4(),
            'grant_type' => 'refresh_token',
            'scope' => $scope,
            'refresh_token' => $RefreshToken,
            'timestamp' => time(),
        ];
        $requestInfo = http_build_query($requestAll);
        return $this->push($requestInfo, self::$requestUrl);
    }

    /**
     * 加密签名
     * @param $timestamp    时间戳
     * @return string       返回加密字符串
     */
    private function GetSign(){
        return md5($this->client_id.time().$this->client_secret);
    }

    //用来唯一标记此次调用，响应对象中会包含相同的id
    private function Uuid4(){
        mt_srand((double)microtime() * 10000);
        $charid = strtolower(md5(uniqid(rand(), true)));
        $hyphen = '-';
        $uuidv4 =
            substr($charid, 0, 8) . $hyphen .
            substr($charid, 8, 4) . $hyphen .
            substr($charid, 12, 4) . $hyphen .
            substr($charid, 16, 4) . $hyphen .
            substr($charid, 20, 12);
        return $uuidv4;
    }

    //解析请求
    private function push($requestInfo,$url)
    {
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检测
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Expect:'
        )); // 解决数据包大不能提交
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $requestInfo); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno' . curl_error($curl);
        }
        curl_close($curl); // 关键CURL会话
        return $tmpInfo; // 返回数据
    }
}