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
<body>
	<?php 
		require_once('init.php');
    	require_once('initsql.php');
		//判定是否授权
	    $code = '';
	    if (isset($_GET["code"])) {
	        $code = $_GET['code'];
	    } else {
	        $callback_url = $HOST_URL . 'video.php';
	        $url = \Pingpp\WxpubOAuth::createOauthUrlForCode($MY_APP_KEY, $callback_url, 'arr+fashioncj', false);
	        header("Location:" . $url);
	        exit();
	    }
	    
	?>
	<div class="main">
		<div class="to-index" style="display: none"><a href="http://mf23.cn/wx/php/main.php">首页</a></div>
		<div id="mediaplayer"></div> 
	</div>
	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/jwplayer.js"></script>
	<script src="js/playvideo.js"></script>
	</body>
</html>