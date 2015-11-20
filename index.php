<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no" />
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<link href="css/player.css" rel="stylesheet">
		<title>2015中国企业家年会</title>
	</head>
	<style>
		body {
			background-color: black;
		}
	</style>
	<body>
		<?php 
			require_once('init.php');
		  	$jssdk = new JSSDK("wxa73bcce2b9c991ce", "6035bcf24f38403455e39568046a4050");
	    	$signPackage = $jssdk->GetSignPackage();

	    	//判定是否授权
	    	
		    $code = '';
		    if (isset($_GET["code"])) {
		        $code = $_GET['code'];
		    } else {
		        $callback_url = $HOST_URL . 'index.php';
		        $url = \Pingpp\WxpubOAuth::createOauthUrlForCode($MY_APP_KEY, $callback_url, 'arr+fashioncj', false);
		        header("Location:" . $url);
		        exit();
		    }
			
		?>
		<video controls="controls" autoplay="autoplay" id="video" poster="images/player.png" width="100%">
		  	<source src="media/Dark_Version_Blue.mp4" type="video/mp4" width="100%" height="100%"/>
		</video>
		<a href="http://mf23.cn/wx/php/main.php" id="next" style="display: none"></a>
	</body>
	<script src="js/jweixin.js"></script>
	<script type="text/javascript">
		wx.config({
	        appId: '<?php echo $signPackage["appId"];?>',
	        timestamp: <?php echo $signPackage["timestamp"];?>,
	        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
	        signature: '<?php echo $signPackage["signature"];?>',
	        jsApiList: [
	            'onMenuShareTimeline',
	        ]
	    });
	    video = document.getElementById('video');
		video.play();
	    document.addEventListener("WeixinJSBridgeReady", function () {
	        video.play();
	    }, false);
	    video.addEventListener("ended", function() {
	    	//alert("ddd");
	    	//window.navigate("http://mf23.cn/wx/php/main.php");
	    	//window.location.href="http://mf23.cn/wx/php/main.php";
	    	document.getElementById("next").click();
	    });
	</script>
</html>