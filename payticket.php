<?php
/**
 * Created by PhpStorm.
 * User: Jia
 * Date: 2015/11/7
 * Time: 21:30
 */
require_once(dirname(__FILE__) . '/init.php');
require_once('initsql.php');


header("Content-Type: text/html;charset=utf-8");

//获取参数表

$t_name='';
$t_phone='';
$t_address='';
$t_kind='';
$t_state='arr+Main';
$t_openid='';

if(isset($_REQUEST['name'])){
    $t_name=$_REQUEST['name'];
}else{
    echo '{"code":3,"message":"no name"}';
    exit();
}

if(isset($_REQUEST['phone'])){
    $t_phone=$_REQUEST['phone'];
}else{
    echo '{"code":3,"message":"no phone"}';
    exit();
}

if(isset($_REQUEST['address'])){
    $t_address=$_REQUEST['address'];
}else{
    echo '{"code":3,"message":"no address"}';
    exit();
}

if(isset($_REQUEST['kind'])){
    $t_kind=$_REQUEST['kind'];
}else{
    echo '{"code":3,"message":"no kind"}';
    exit();
}

if(isset($_REQUEST['state'])){
    $t_state=$_REQUEST['state'];
}else{
    echo '{"code":3,"message":"no state"}';
    exit();
}

if(isset($_REQUEST['openid'])){
    $t_openid=$_REQUEST['openid'];
}else{
    echo '{"code":3,"message":"no openid"}';
    exit();
}

//合法性检查

$t_name=mysqli_real_escape_string($con,$t_name);
$t_address=mysqli_real_escape_string($con,$t_address);
$t_state=mysqli_real_escape_string($con,str_replace('arr','',$t_state));
$t_openid=mysqli_real_escape_string($con,$t_openid);
$t_kind=mysqli_real_escape_string($con,$t_kind);
if(preg_match("/^(0|86|17951)?(13[0-9]|15[012356789]|17[6780]|18[0-9]|14[57])[0-9]{8}$/",$t_phone)){

}else{
    echo '{"code":3,"message":"invalud phonenumber"}';
    exit();
}

$subject="";
$amount = 99900;
switch($t_kind){
    case 1:
        $amount=499900;
        $subject="私董席（定金）";
        break;
    case 2:
        $amount=299900;
        $subject="钻石席";
        break;
    case 3:
        $amount=199900;
        $subject="铂金席";
        break;
    case 4:
        $amount=139900;
        $subject="黄金席";
        break;
    case 5:
        $amount=99900;
        $subject="嘉宾席";
        break;
    default:
        echo '{"code":3,"message":"invalud kind"}';
        exit();
}

//获取js签名
//$jssdk = new JSSDK($MY_APP_KEY, $MY_APP_SECRET);
//$signPackage = $jssdk->GetSignPackage();
//$js_signature=$signPackage["signature"];
//echo '$js_signature='.$js_signature.'</br>';
//var_dump($t_name);
//var_dump($t_phone);
//var_dump($t_address);
//var_dump($t_kind);
//var_dump($t_state);
//var_dump($t_openid);

//计算订单过期时间
$expire_time=time() + (30 * 60);

//数据库操作

$id='';//订单号前半部分


//状态恢复
$sql="select id from ticket WHERE state=1 AND openid='{$t_openid}' AND kind='{$t_kind}' ";
$query=mysqli_query($con,$sql);
$cancle_id=mysqli_fetch_array($query)['id'];
//echo $cancle_id;
if(strlen($cancle_id)<16){
    //新订单
    $sql="select min(ticket.index) from ticket where state=0 and kind='{$t_kind}'";
    $sql_id="select id from ticket WHERE ticket.index=($sql)";
    $id=mysqli_fetch_array(mysqli_query($con,$sql_id))['id'];
    $sql="select min(tmp1.index) from (select tmp.* from ticket tmp) tmp1 where tmp1.state=0 and tmp1.kind='{$t_kind}'";
    $sql_update="UPDATE ticket SET state=1,name='{$t_name}',phone='{$t_phone}',address='{$t_address}',arr='{$t_state}',openid='{$t_openid}' WHERE ticket.index=($sql)";
    $query=mysqli_query($con,$sql_update);
    if($query){
        $sql_comfirm="select id from ticket WHERE state=1 AND kind='{$t_kind}' AND openid='{$t_openid}'";
        $comfirm_id=mysqli_fetch_array(mysqli_query($con,$sql_comfirm))['id'];
        //echo $id.$comfirm_id;
        if(strcmp($comfirm_id,$id)==0){
            echo '{"code":0,"message":"new order",';
        }else{
            echo '{"code":3,"message":"sql error"}';
            mysqli_close($con);
            exit();
        }
    }else{
        echo '{"code":3,"message":"sql error at update"}';
        mysqli_close($con);
        exit();
    }
}else{
    $sql_update="UPDATE ticket SET state=1,name='{$t_name}',phone='{$t_phone}',address='{$t_address}',arr='{$t_state}',openid='{$t_openid}' WHERE id='{$cancle_id}'";
    $query=mysqli_query($con,$sql_update);
    if($query){
        echo '{"code":1,"message":"old order",';
        $id=$cancle_id;
    }
}



//生成订单

$t=time();
$orderNo = substr($id, 0, 8).substr($t_openid,21).$t;
$orderNo=str_replace('-','',$orderNo);

//ping++ part

//\Pingpp\Pingpp::setApiKey('sk_test_SSarLCPCi5eHanrLCOeH0ar5'); //测试key
\Pingpp\Pingpp::setApiKey('sk_live_GWD8WLDqbTOSqb9er5W9CGi5'); //真实key
$channel = strtolower("wx_pub");
$extra = array('open_id' => $t_openid);

try {
    $ch = \Pingpp\Charge::create(
        array(
            'subject'   => '2015中国企业家年会'.$subject,
            'body'      => $t_name.':'.$t_phone.':'.$t_address,
            'amount'    => $amount,
            'order_no'  => $orderNo,
            'currency'  => 'cny',
            'extra'     => $extra,
            'channel'   => $channel,
            'client_ip' => $_SERVER['REMOTE_ADDR'],
            'app'       => array('id' => 'app_90iv9CinvL40yDWT'),
            'time_expire' => $expire_time
        )
    );

    echo '"charge":'.$ch.'}';
} catch (\Pingpp\Error\Base $e) {
    header('Status: ' . $e->getHttpStatus());
    echo($e->getHttpBody());
}


mysqli_close($con);
