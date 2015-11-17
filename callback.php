<?php
/**
 * Created by PhpStorm.
 * User: Jia
 * Date: 2015/11/8
 * Time: 1:17
 */
echo $_GET['state'];

if(isset($_GET["code"])){
    $code=$_GET['code'];
}else{
    echo '<a href="index.php">授权失败，请点击重试</a>';
    exit();
}

$openid=\Pingpp\WxpubOAuth::getOpenid($MY_APP_KEY,$MY_APP_SECRET,$code);
echo $openid;
echo "<a href=\"payticket.php?name=fashioncj&phone=133&address=济南&kind=1&openid=$openid\">购票</a>";