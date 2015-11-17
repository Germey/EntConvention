<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <title>企业年会</title>
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
        $callback_url = $HOST_URL . 'php/index.php';
        $url = \Pingpp\WxpubOAuth::createOauthUrlForCode($MY_APP_KEY, $callback_url, 'arr+fashioncj', false);
        header("Location:" . $url);
        exit();
    }
    
    //判定推广
    $state = 'arr+Main';
    if (isset($_GET['state'])) {
        $state = $_GET['state'];
    }

    //获取open_id
    $openid = \Pingpp\WxpubOAuth::getOpenid($MY_APP_KEY, $MY_APP_SECRET, $code);
    

    //查询余票，清除锁定
    $nowitme = time() - (45 * 60);
    $nowitme = date("Y-m-d H:i:s", $nowitme);
    $sql = "UPDATE ticket SET state=0 WHERE state=1 AND locktime<'{$nowitme}'";
    $query = mysqli_query($con, $sql);
    $kind_count = array();
    if ($query) {
        $sql = "select kind,count(state) as count from ticket where state=0 group by kind order by kind";
        $query=mysqli_query($con,$sql);
        while($row=mysqli_fetch_array($query)){
            $kind_count[$row['kind']] = $row['count'];
        }
    } else {
        echo "连接数据库出错!";
        mysqli_close($con);
        exit();
    }


?>
    <div class="wrap">
        <div class="bg">
            <img src="images/bg.png">
        </div>
        <div id="nav">
            <div class="btns">
                <a name="intro" class="btn intro">大会介绍</a>
                <a name="guest" class="btn guest">来宾介绍</a>
                <a name="focus" class="btn letter">给你的信</a>
            </div>
            <div class="bottoms">
                <div class="row">
                    <div class="col-xs-6 col">
                        <a name="seat" class="btn">点击购票</a>
                    </div>
                    <div class="col-xs-6 col">
                        <img src="images/index_logo.png">
                    </div>
                </div>
            </div>
        </div>
        <div id="intro" class="con low">
            <div class="title">
                <div class="name pull-left">
                    <span>大会介绍</span>
                </div>
                <div class="close pull-right">
                    <span>x</span>
                </div>
            </div>
            <div class="content">
                <div class="top-tag">
                    <span>导读</span>
                </div>
                <div class="details">
                    <img src="images/intro/img1.png">
                    <p>2015年是“十二五”收官之年，也是“十三五”谋局之年，更是中国经济转变发展模式进入新常态后的变局之年。决胜未来—2015中国企业家年会在此背景下隆重召开，旨在就宏观形势和热点议题展开深入研讨，帮助企业了解更多全球及国内宏观经济环境及政策走向等问题，协助企业准确研判市场变化，承上启下制定发展规划，做好企业决策。
2015—中国企业家年会，将邀请部委领导、企业领袖、商界大佬及知名专家现场做精彩分享，相关会议成果将见诸于公众媒体，形成舆论最强音。</p>
                    <img src="images/intro/img2.png">
                </div>
            </div>
        </div>
        <div id="focus" class="con low">
            <div class="title">
                <div class="name pull-left">
                    <span>大会介绍</span>
                </div>
                <div class="close pull-right">
                    <span>x</span>
                </div>
            </div>
            <div class="content">
                <div class="top-tag">
                    <span>会议热点</span>
                </div>
                <div class="details">
                    <h2>资本</h2>
                    <img src="images/focus/img1.png">
                    <p>追求高速成长的企业都会在10年内采取积极向外扩张的大动作，例如外延增长，开展新业务，或者进行大的变革，这些都需要借助资本的力量。对企业来说，重大变革需要战略革命，也需要对接资本市场进行融资渠道的开拓。那么当机会来了，企业该如何应对兼并收购的机会？如何为直接融资开通渠道？未来企业兼并重组之后的股权结构如何设计？又如何保证创始股东的利益?</p>
                    <h2>互联网+</h2>
                    <p>“互联网+”和中国资本市场正在成为中国经济转型最重要的两个引擎。2015年两会，“互联网+”首次写入了《政府工作报告》，成为国家战略的一部分。国家要推动移动互联网、云计算</p>
                </div>
            </div>
        </div>
        <div id="guest" class="con low">
            <div class="title">
                <div class="name pull-left">
                    <span>来宾介绍</span>
                </div>
                <div class="close pull-right">
                    <span>x</span>
                </div>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img1.png">
                            <div class="name">
                                蒋树声
                            </div>
                            <div class="brief">
                                原人大常委会委员长
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img2.png">
                            <div class="name">
                                王忠禹
                            </div>
                            <div class="brief">
                                原政协副主席中国企业联合会会长
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img3.png">
                            <div class="name">
                                龙永图
                            </div>
                            <div class="brief">
                                原外经贸副部长<br>现任全球CEO发展大会联合主席
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img4.png">
                            <div class="name">
                                周禹鹏
                            </div>
                            <div class="brief">
                                前上海市副市长<br>现代服务业联合会会长
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="seat" class="con low">
            <div class="title">
                <div class="name pull-left">
                    <span>购票信息</span>
                </div>
                <div class="close pull-right">
                    <span>x</span>
                </div>
            </div>
            <div class="content">
                <div class="top-tag">
                    <span>坐席示意图</span>
                </div>
                <div class="details">
                    <img src="images/seat/img1.png">
                    <div class="text-center">
                        <a name="buy" class="btn">立即购票</a>
                    </div>
                    <p><b>座位介绍：</b>座位分为五种，分别为私董席、钻石席、铂金席、白金席、嘉宾席</p>
                </div>
            </div>
        </div>
        <div id="buy" class="con low">
            <div class="title">
                <div class="name pull-left">
                    <span>购票信息</span>
                </div>
                <div class="close pull-right">
                    <span>x</span>
                </div>
            </div>
            <div class="content">
                <div class="bg-img">
                    <img src="images/buy/bg.png">
                </div>
                <div class="buy-con">
                    <div class="choose">
                        <span>选择票类：</span>
                        <div class="row">
                            <div class="col-xs-6 item">
                                <div kind="" class="choose-btn <?php echo intval($kind_count[5])<=0?'disabled':''?>" rank="5">嘉宾席：999元</div>
                            </div>
                            <div class="col-xs-6 item">
                                <div kind="" class="choose-btn <?php echo intval($kind_count[4])<=0?'disabled':''?>" rank="4">白金席：1399元</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 item">
                                <div kind="" class="choose-btn <?php echo intval($kind_count[3])<=0?'disabled':''?>" rank="3">铂金席：1999元</div>
                            </div>
                            <div class="col-xs-6 item">
                                <div kind="" class="choose-btn <?php echo intval($kind_count[2])<=0?'disabled':''?>" rank="2">钻石席：2999元</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 item">
                                <div kind="" class="choose-btn <?php echo intval($kind_count[1])<=0?'disabled':''?>" rank="1">私董席：29999元</div>
                            </div>
                        </div>
                    </div>
                    <div class="contact">
                        <span>联系方式：</span>
                        <form class="contact-form" role="form">
                            <div class="form-group">
                                <input class="form-control" placeholder="姓名" id="form-name">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="手机号码" id="form-phone">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="地址" id="form-address">
                            </div>
                        </form>
                        <div class="text-center">
                            <a id="to-confirm" class="btn">下一步</a>
                        </div>
                    </div>
                </div>
            </div>
         </div>
        <div id="confirm" class="con low">
            <div class="title">
                <div class="name pull-left">
                    <span>购票信息</span>
                </div>
                <div class="close pull-right">
                    <span>x</span>
                </div>
            </div>
            <div class="content">
                <div class="bg-img">
                    <img src="images/buy/bg.png">
                </div>
                <div class="buy-con">
                    <div class="info">
                        <div class="ticket">
                            白金席：1399元
                        </div>
                        <input type="hidden" id="ticket-rank" name="ticket-rank" value="">
                        <div class="name">
                            <span>姓  名：</span>
                            <span id="confirm-name"></span>
                        </div>
                        <div class="phone">
                            <span>手机号码：</span>
                            <span id="confirm-phone"></span>
                        </div>
                        <div class="address">
                            <span>地址：</span>
                            <span id="confirm-address"></span>
                        </div>
                    </div>
                    <div class="hr"></div>
                    <div class="choose">
                        <span>选择支付方式：</span>
                        <div class="row">
                            <div class="col-xs-6 item">
                                <div kind="" class="choose-btn choosen">微信支付</div>
                            </div>
                            <div class="col-xs-6 item">
                                <div kind="" class="choose-btn">汇款信息</div>
                            </div>
                        </div>
                    </div>
                    <div class="btns">
                        <div class="row">
                            <div class="col-xs-6 item">
                                <div id="back-to-edit" class="btn">返回修改</div>
                            </div>
                            <div class="col-xs-6 item">
                                <div id="buy-button" class="btn">确认支付</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="success" class="con low">
            <div class="title">
                <div class="name pull-left">
                    <span>购票状态</span>
                </div>
                <div class="close pull-right">
                    <span>x</span>
                </div>
            </div>
            <div class="content">
                <div class="bg-img">
                    <img src="images/buy/bg.png">
                </div>
                <div class="status">
                    <div class="info-text">
                        <p>恭喜您</p>
                        <p>购票成功!</p>
                    </div>
                    <img class="icon" src="images/status/success.png">
                    <p>72小时内会有工作人员联系您,请保持手机在开机状态。<br>如有疑问请拨打：021-xxxxxxxx</p>
                    <p>以下是您的购票信息:</p>
                    <div class="result">
                        <img src="images/status/info.png">
                        <div class="details">
                            <div id="success-ticket">
                                
                            </div>
                            <div class="name">
                                <span>姓  名：</span>
                                <span id="success-name"></span>
                            </div>
                            <div class="phone">
                                <span>手机号码：</span>
                                <span id="success-phone"></span>
                            </div>
                            <div class="phone">
                                <span>地址：</span>
                                <span id="success-address"></span>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
        <!-- 提示框 -->
        <div class="modal" id="mymodal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">温馨提示</h4>
                    </div>
                    <div class="modal-body">
                        <p>请填写有效信息</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">确定</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
    <script src="js/jquery-1.9.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="lib/pingpp.js" type="text/javascript"></script>
    <script src="js/main.js"></script>
    <script>
    $(function() {
        $("#buy-button").on("click", function() {
            var name = $("#confirm-name").html();
            var phone = $("#confirm-phone").html();
            var address = $("#confirm-address").html();
            var kind = $("#ticket-rank").val();
            var openid = "<?php echo $openid; ?>";
            var state = "<?php echo $state; ?>";
            var url = "payticket.php?name="+name+"&phone="+phone+"&address="+address+"&kind="+kind+"&openid="+openid+"&state="+state;
            var xhr = new XMLHttpRequest();
            xhr.open("POST", url, true);
            xhr.send(null);
            alert(url);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert(xhr.responseText);
                    var msg = xhr.responseText;
                    var jsons = eval("("+msg+")");
                    //alert(jsons.message);
                    pingpp.createPayment(jsons.charge, function(result, err) {
                        if (result == "success") {
                            // 只有微信公众账号 wx_pub 支付成功的结果会在这里返回，其他的 wap 支付结果都是在 extra 中对应的 URL 跳转。
                            $("#success-ticket").html($("#confirm .ticket").text());
                            $("#confirm-name").html(name);
                            $("#confirm-phone").html(phone);
                            $("#confirm-address").html(address);
                            $("#confirm").addClass("low");
                            $("#success").removeClass("low");
                        } else if (result == "fail") {
                            // charge 不正确或者微信公众账号支付失败时会在此处返回
                            alert("创建订单失败或付款失败，请重试");
                        } else if (result == "cancel") {
                            // 微信公众账号支付取消支付
                            alert("支付已经取消");
                        }
                    });
                }
            }
        });
    });
    </script>
</body>
</html>


