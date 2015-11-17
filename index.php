<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: Jia
 * Date: 2015/11/8
 * Time: 1:01
 */

require_once('init.php');
require_once('initsql.php');
header("Content-Type: text/html;charset=utf-8");


//判定是否授权
$code = '';
if (isset($_GET["code"])) {
    $code = $_GET['code'];
} else {
    $callback_url = $HOST_URL . 'php/index.php';
//  $scope='snsapi_base';
//  $scope='snsapi_userinfo';//需要授权
    $url = \Pingpp\WxpubOAuth::createOauthUrlForCode($MY_APP_KEY, $callback_url, 'arr+fashioncj', false);
//    echo $url;
//    echo $callback_url;
    header("Location:" . $url);
    exit();
}

//判定推广
$state = 'arr+Main';
if (isset($_GET['state'])) {
    $state = $_GET['state'];
} else {

}

//获取open_id
$openid = \Pingpp\WxpubOAuth::getOpenid($MY_APP_KEY, $MY_APP_SECRET, $code);
echo $openid.'<br>';
//echo "<a href=\"payticket.php?name=陈佳&phone=13489092003&address=济南&kind=1&openid=$openid&state=arr+fashioncj\">购票</a>";

//查询余票&&清除锁定

$nowitme = time() - (45 * 60);
$nowitme = date("Y-m-d H:i:s", $nowitme);
$sql = "UPDATE ticket SET state=0 WHERE state=1 AND locktime<'{$nowitme}'";
$query = mysqli_query($con, $sql);
if ($query) {
    $sql = "select kind,count(state) from ticket where state=0 group by kind order by kind";
    $query=mysqli_query($con,$sql);
    while($row=mysqli_fetch_array($query)){
        echo $row['kind'] . " " . $row['count(state)'];
        echo "<br />";
    }
} else {
    echo "FAIL TO CONNECT DATEBASE!";
    mysqli_close($con);
    exit();
}

//$query=mysqli_query($con,$sql);


mysqli_close($con);
?>
<br>
<a href="javascript:void(0);" onclick="wap_pay()">购票测试</a>
<script src="lib/pingpp.js" type="text/javascript"></script>
<script>
    function wap_pay() {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "payticket.php?name=陈佳&phone=13489092003&address=济南&kind=1&openid=<?php echo $openid?>&state=arr+fashioncj", true);
        xhr.send(null);

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText);
                var msg=xhr.responseText;
                var jsons=eval("("+msg+")");
                //alert(jsons.message);
                pingpp.createPayment(jsons.charge, function (result, err) {
                    if (result == "success") {
                        // 只有微信公众账号 wx_pub 支付成功的结果会在这里返回，其他的 wap 支付结果都是在 extra 中对应的 URL 跳转。
                        alert("success");
                    } else if (result == "fail") {
                        // charge 不正确或者微信公众账号支付失败时会在此处返回
                        alert("创建订单失败或付款失败，请重试");
                    } else if (result == "cancel") {
                        // 微信公众账号支付取消支付
                        alert("cancel");
                    }
                });
            }
        }
    }
</script>
</body>
</html>


