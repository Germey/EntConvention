<?php
/**
 * Created by PhpStorm.
 * User: Jia
 * Date: 2015/11/9
 * Time: 21:48
 */

$event = json_decode(file_get_contents("php://input"));

// 验证 webhooks 签名
function verify_signature($raw_data, $signature, $pub_key_path)
{
    $pub_key_contents = file_get_contents($pub_key_path);
    // php 5.4.8 以上，第四个参数可用常量 OPENSSL_ALGO_SHA256
    return openssl_verify($raw_data, base64_decode($signature), $pub_key_contents, 'sha256');
}

// 对异步通知做处理
if (!isset($event->type)) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
    exit("fail");
}
switch ($event->type) {
    case "charge.succeeded":
        // 开发者在此处加入对支付异步通知的处理代码
        // POST 原始请求数据是待验签数据，请根据实际情况获取
        $raw_data = file_get_contents('php://input');
        // 签名在头部信息的 x-pingplusplus-signature 字段
        $header_name="x-pingplusplus-signature";
        $signature="";
        foreach (getallheaders() as $name => $value) {
           // echo "$name: $value\n";
            if(strcmp($name,$header_name)==0){
                $signature=$value;
            }
        }
        //echo '$signature'.$signature;
        // 请从 https://dashboard.pingxx.com 获取「Webhooks 验证 Ping++ 公钥」
        $pub_key_path = __DIR__ . "/rsa_public_key.pem";
        $result = verify_signature($raw_data, $signature, $pub_key_path);
        if ($result === 1) {
            echo 'verification succeeded';
            require_once('initsql.php');
            $nowitme = date("Y-m-d H:i:s", time());
            $charge=file_get_contents("php://input");
            $sql="INSERT INTO result (charge) VALUES ('{$charge}')";
            echo  $sql.'</br>';
            mysqli_query($con,$sql);
            $order_no=$event->data->object->order_no;
            //echo $order_no;
            $sql="select ticket.index from ticket where CONCAT(left(id,16),substring(openid,13))='$order_no'";
            echo  $sql.'</br>';
            $index=mysqli_fetch_array(mysqli_query($con,$sql))['index'];
            $sql="update ticket set state=2,buytime='{$nowitme}' WHERE ticket.index='{$index}'";
            echo  $sql.'</br>';
            if(mysqli_query($con,$sql)){
                echo "success";
            }else{
                echo "error";
            }
            mysqli_close($con);
            header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
        } elseif ($result === 0) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
            echo 'verification failed';
        } else {
            header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
            echo 'verification error';
        }
        break;
    case "refund.succeeded":
        // 开发者在此处加入对退款异步通知的处理代码
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
        break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
        break;
}

