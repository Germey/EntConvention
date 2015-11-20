<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
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
        $callback_url = $HOST_URL . 'main.php';
        $url = \Pingpp\WxpubOAuth::createOauthUrlForCode($MY_APP_KEY, $callback_url, 'arr+fashioncj', false);
        header("Location:" . $url);
        exit();
    }
    
    //判定推广
    $state = 'arr+Main';
    if (isset($_GET['state'])) {
        $state = $_GET['state'];
    }

    // JSSDK
    $jssdk = new JSSDK("wxa73bcce2b9c991ce", "6035bcf24f38403455e39568046a4050");
    $signPackage = $jssdk->GetSignPackage();

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
    <div class="icon" style="display: none">
        <img src="images/logo_s.png">
    </div>
    <div class="wrap">
        <div class="bg">
            <img src="images/bg.png">
        </div>
        <div id="nav">
            <div class="btns">
                <a name="intro" class="btn intro">大会介绍</a>
                <a name="guest" class="btn guest">来宾介绍</a>
                <a name="focus" class="btn letter">会议热点</a>
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
                <div id="nav-copy" class="copyright" style="display: none">复树文化出品</div>
            </div>
        </div>
        <div id="intro" class="con low">
            <div class="title">
                <div class="name pull-left">
                    <span>大会介绍</span>
                </div>
                <div class="close pull-right">
                    <img class="close-con" src="images/close.png">
                </div>
            </div>
            <div class="content">
                <div class="top-tag">
                    <span>导读</span>
                </div>
                <div class="details">
                    <img src="images/intro/img1.png">
                    <p>2015年是“十二五”收官之年，也是“十三五”谋局之年，更是中国经济转变发展模式进入新常态后的变局之年。决胜未来—2015中国企业家年会在此背景下隆重召开，旨在就宏观形势和热点议题展开深入研讨，帮助企业了解更多全球及国内宏观经济环境及政策走向等问题，协助企业准确研判市场变化，承上启下制定发展规划，做好企业决策。</p>
                    <p>2015—中国企业家年会，将邀请部委领导、企业领袖、商界大佬及知名专家现场做精彩分享，相关会议成果将见诸于公众媒体，形成舆论最强音。</p>
                    <img src="images/intro/img2.png">
                    <h2>最具价值的参会者</h2>
                    <p class="noindent">10位政府要员<br>20位商界大咖<br>100位行业领袖<br>5000位中小企业家代表<br>他们充满激情、正能量、渴望实现梦想！</p>
                    <h2>最精彩的流程安排</h2>
                    <p class="noindent">智者对话—商界大咖唇枪舌战、思维碰撞!<br>主题分享—现场聆听权威专家和商界大咖对未来的重新想象<br>名流酒会—与政府要员、商界大咖近距离接触、零距离互动</p>
                    <h2>最超值的回报</h2>
                    <p class="noindent">最精准的品牌传播平台<br>最优质的人脉资源拓展<br>最好的表达、链接机会
                    <div class="copyright">复树文化出品</div>
                </div>
            </div>
        </div>
        <div id="focus" class="con low">
            <div class="title">
                <div class="name pull-left">
                    <span>大会介绍</span>
                </div>
                <div class="close pull-right">
                    <img class="close-con" src="images/close.png">
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
                    <p>“互联网+”和中国资本市场正在成为中国经济转型最重要的两个引擎。2015年两会，“互联网+”首次写入了《政府工作报告》，成为国家战略的一部分。国家要推动移动互联网、云计算、大数据、物联网等与现代产业结合，让更多的传统行业经过互联网改造后“在线化、数据化”，从而使信息和数据转化成巨大的生产力，成为社会财富增长的新源泉。那么，“互联网+”将促进哪些产业的转型升级？企业又该如何应对，以适应这种产业布局？</p>
                    <h2>股权众筹及上市</h2>
                    <p>2015年中国互联网金融出现了蓬勃发展之势。尤其在Kickstarter、Indiegogo等众筹平台在国外走红后，这种通过群众集资的方式获得资金援助用以实现创意及梦想的新兴方式为国内大众所效仿。众筹模式受到各领域创业者的争相分食。看国内，淘宝、京东相继上线了众筹频道，国务院工作会议更是多次提到“股权众筹”这个风头敏感话题，股权众筹的春天真的来了吗？</p>
                    <p>谈到上市大家一定会想到上市板块中的一个巨大风口—新三板。最新数据公布，越来越多人相信，新三板正成为新的造福机器，杨丽萍通过新三板身价近40亿，孙红雷从新三板赚7000万。那么您能抓住今天的新三板机遇吗？</p>
                    <h2>模式创新与企业变革</h2>
                    <p>在全球化浪潮冲击、技术变革加快及商业环境变得更加不确定的时代，决定企业成败最重要的因素，不是技术，而是商业模式。那么与技术相比，模式创新有哪些特点？国际上通过模式创新获得巨大商业成功的案例有哪些？我们将如何推动企业的商业模式创新？</p>
                    <img src="images/focus/img4.png">
                    <h2>决胜未来—看中国未来10年</h2>
                    <p>中国经历了30多年的快速发展之后，目前又再经历新的巨大转型，而且问题更复杂，影响更深远。各领域权威和商界大咖将逐一阐述他们理解的中国“改革学”， 共同探讨中国企业所面临的新常态、新风口、新机遇。看他们如何应对新形势下的挑战，如何在解决社会问题的过程中找到商机，并最终改变未来的经济增长模式，我们期待他们的对话与争锋。</p>
                </div>
                <br>
                <div class="top-tag">
                    <span>年会信息</span>
                </div>
                <div class="details">
                    <p class="noindent">
                        【会议主题】决胜未来—2015中国企业家年会<br>
                        【会议时间】2015年12月26日至27日<br>
                        【会议地点】中国.上海<br>
                        【主办单位】唐骏资本商学院<br>
                        【承办单位】上海擎川文化传播有限公司、杭州帮达文化创意有限公司、上海承瑾文化传播有限公司<br>
                        【协办单位】丝绸之路国际企业联合会、金融邦控股集团、广州智囊互联网服务股份有限公司、浙江融天下电子商务有限公司<br>
                        【媒体支持】中国经营报 环球时报 南风窗 第一财经频道 CCTV证券频道 东方卫视 北京卫视 东方企业家 新浪网 网易 雅虎 腾讯 凤凰网 中华网 搜狐 央视网 新华网 TOM 中国企业新闻网 和讯网 金融界等60家媒体<br>
                        【参会对象】各企业事业董事长、总经理、商务精英、社会知名人士、中小微企业老板、项目创始发起人、股东等<br>
                        【席位介绍】1、嘉宾席；2、黄金席；3、铂金席；4、钻石席
                    </p>
                    <p class="noindent">
                        一次不容错过的盛会<br>
                        一次创造财富的商旅<br>
                        2015 中国企业家年会，最后一场压轴盛宴……
                    </p>
                    <img src="images/focus/img6.png">
                    <div class="copyright">复树文化出品</div>
                </div>
            </div>
        </div>
        <div id="guest" class="con low">
            <div class="title">
                <div class="name pull-left">
                    <span>来宾介绍</span>
                </div>
                <div class="close pull-right">
                    <img class="close-con" src="images/close.png">
                </div>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img1.png">
                            <div class="name">
                                龙永图
                            </div>
                            <div class="brief">
                                原外经贸副部长<br>
                                全球CEO发展大会联合主席<br>
                                中国与全球化智库主席<br>
                                央视2003年度经济人物<br>
                                中国入世谈判的首席谈判代表
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img2.png">
                            <div class="name">
                                柳传志
                            </div>
                            <div class="brief">
                                联想集团创始人 <br>
                                中国改革风云人物 <br>  
                                全球最具影响力50大商业思想家 <br>       
                                现任联想集团有限公司董事局名誉主席<br>
                                联想集团高级顾问
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img3.png">
                            <div class="name">
                                潘石屹
                            </div>
                            <div class="brief">
                                SOHO中国董事长<br>    
                                最独领风骚的地产娱乐大师<br>      
                                最善于“引势导利”的营销大师   
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img4.png">
                            <div class="name">
                                俞敏洪
                            </div>
                            <div class="brief">
                                新东方教育科技集团董事长<br>         
                                洪泰基金联合创始人<br>
                                中国最具影响力的50位商界领袖<br>
                                中国最具魅力校长”称号 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img5.png">
                            <div class="name">
                                李开复
                            </div>
                            <div class="brief">
                                创新工场董事长兼首席执行官<br>
                                曾任Google、微软全球副总裁<br>
                                “真正成功的公司源于伟大的创业理念”<br>
                                “只有创意没有执行力必然失败，只有执行力而创意欠缺，还是有机会成功”
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img6.png">
                            <div class="name">
                                项兵
                            </div>
                            <div class="brief">
                                曾任教于香港科技大学、
                                上海中欧国际工商学院和北京大学<br>
                                曾是中欧国际工商学院第一批(七名)核心教授之一<br>
                                北京大学光华管理学院EMBA和EDP的创办主任和博士生导师<br>
                                现任长江商学院教授和创办院长
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img7.png">
                            <div class="name">
                                张云峰
                            </div>
                            <div class="brief">
                                上海股权托管交易中心总经理、党委书记
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img8.png">
                            <div class="name">
                                牛根生
                            </div>
                            <div class="brief">
                                蒙牛乳业集团创始人<br>
                                老牛基金会创始人、名誉会长<br>
                                “全球捐股第一人” 1999年创立蒙牛，后用短短8年时间，使蒙牛成为全球液态奶冠军、中国乳业总冠军。

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img9.png">
                            <div class="name">
                                周禹鹏
                            </div>
                            <div class="brief">
                                前上海市副市长<br>
                                市人大常委会副主任<br>
                                现代服务业联合会会长
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img10.png">
                            <div class="name">
                                董明珠
                            </div>
                            <div class="brief">
                                格力电器董事长兼总裁<br>
                                全球100位最佳CEO<br>
                                中国经济年度人物年度经济人物奖<br>
                                《财富》亚太最具影响力的25位商界女性
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img11.png">
                            <div class="name">
                                郎咸平
                            </div>
                            <div class="brief">
                                知名学者 著名财经节目评论人<br>
                                2003年荣登世界经济学家名人录<br>
                                公认的世界金融学的顶级学者<br>
                                中国互联网九大风云人物之一<br> 
                                最活跃的中青年财务金融学家之一
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img12.png">
                            <div class="name">
                                秦志辉
                            </div>
                            <div class="brief">
                                中国科学院副研究员<br>
                                中国科学院武汉物理与数学所，副研究员<br>
                                工业和信息化部中小企业发展促进中心主任
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img13.png">
                            <div class="name">
                                孟晓苏
                            </div>
                            <div class="brief">
                                 “中国房地产之父”原国家进出口检验局副局长<br> 
                                 原中房集团董事长<br>
                                 原幸福人寿董事长（幸福人寿创办人）<br>
                                 现担任中房集团理事长、中国企业家联合会执行副会长等职务。
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img14.png">
                            <div class="name">
                                李佐军
                            </div>
                            <div class="brief">
                                国务院发展研究中心资源与环境政策研究所副所长<br>
                                著名经济学家，人本发展理论创立者<br>
                                著有《人本发展理论》等五部专著
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img15.png">
                            <div class="name">
                                洪清华
                            </div>
                            <div class="brief">
                                驴妈妈旅游网创始人<br>
                                景域国际旅游运营集团董事长<br>
                                现任驴妈妈董事长 70年代的创业代表
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img16.png">
                            <div class="name">
                                张旭豪
                            </div>
                            <div class="brief">
                                饿了么网上订餐平台创始人兼CEO<br>
                                饿了么获6.3亿美元融资 创全球外卖行业最高纪录<br>
                                与美国GrubHub、德国Delivery Hero、英国JustEat同为全球价值最高的外卖巨头 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img17.png">
                            <div class="name">
                                冯仑
                            </div>
                            <div class="brief">
                                万通控股董事长<br>
                                阿拉善SEE生态协会第四任会长<br>
                                全国工商联房地产商会副会长<br>
                                中华民营企业联合会常务副会长<br>
                                中国房地产协会常务理事<br>
                                全国房地产经理人联盟荣誉主席
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img18.png">
                            <div class="name">
                                王忠禹
                            </div>
                            <div class="brief">
                                原政协副主席<br>
                                中国企业联合会会长<br>
                                国务委员、国务院秘书长、国家行政学院院长<br>
                                国家经济贸易委员会主任、党组书记
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img19.png">
                            <div class="name">
                                蒋树声
                            </div>
                            <div class="brief">
                                原人大常委会委员长<br> 
                                十一届全国人大常委会副委员长<br>
                                民盟中央主席<br>
                                国务院学位委员会委员<br> 
                                南京大学校长
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col">
                        <div class="item">
                            <img src="images/guest/img20.png">
                            <div class="name">
                                唐骏
                            </div>
                            <div class="brief">
                                中国资本的第一人<br> 
                                中国打工皇帝<br> 
                                微软(中国)终身荣誉总裁<br> 
                                微创（中国）董事长
                            </div>
                        </div>
                    </div>
                </div>
                <div class="copyright">复树文化出品</div>
            </div>
        </div>

        <div id="seat" class="con low">
            <div class="title">
                <div class="name pull-left">
                    <span>购票信息</span>
                </div>
                <div class="close pull-right">
                    <img class="close-con" src="images/close.png">
                </div>
            </div>
            <div class="content">
                <div class="top-tag">
                    <span>坐席示意图</span>
                </div>
                <div class="details">
                    <img src="images/seat/img1.png" id="seat-img">
                    <div class="text-center">
                        <a name="buy" class="btn">立即购票</a>
                    </div>
                    <p><b>座位介绍：</b><br>私董席：前排座席，与大咖互动，共进圆桌宴<br>钻石席：内场座席，超强能量场，与大咖近距离接触<br>铂金席：一层看台座席，直面大咖，TED气息<br>白金席：二层看台座席，多角度感观，全方位视听<br>嘉宾席：三层看台座席，纵览全局，超高性价比</p>
                    <div class="copyright">复树文化出品</div>
                </div>
            </div>
        </div>
        <div id="buy" class="con low">
            <div class="title">
                <div class="name pull-left">
                    <span>购票信息</span>
                </div>
                <div class="close pull-right">
                    <img class="close-con" src="images/close.png">
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
                                <div kind="" class="choose-btn <?php echo intval($kind_count[1])<=0?'disabled':''?>" rank="1">私董席</div>
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
                <div class="copyright">复树文化出品</div>
            </div>
         </div>
        <div id="confirm" class="con low">
            <div class="title">
                <div class="name pull-left">
                    <span>购票信息</span>
                </div>
                <div class="close pull-right">
                    <img class="close-con" src="images/close.png">
                </div>
            </div>
            <div class="content">
                <div class="bg-img">
                    <img src="images/buy/bg.png">
                </div>
                <div class="buy-con">
                    <div class="info">
                        <div class="ticket">
                            
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
                                <div kind="" class="choose-btn" id="finance-btn">汇款信息</div>
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
                <div class="copyright">复树文化出品</div>
            </div>
        </div>
        <div id="success" class="con low">
            <div class="title">
                <div class="name pull-left">
                    <span>购票状态</span>
                </div>
                <div class="close pull-right">
                    <img class="close-con" src="images/close.png">
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
                    <p>72小时内会有工作人员联系您,请保持手机在开机状态。<br>如有疑问请拨打：<a href="tel://021-59882097">021-59882097</a></p>
                    <p>以下是您的购票信息:</p>
                    <div class="result">
                        <img src="images/status/info.png">
                        <div class="details">
                            <div id="success-ticket">
                            </div>
                            <div class="name">
                                <span>姓名：</span>
                                <span id="success-name"></span>
                            </div>
                            <div class="phone">
                                <span>电话：</span>
                                <span id="success-phone"></span>
                            </div>
                            <div class="phone">
                                <span>地址：</span>
                                <span id="success-address"></span>
                            </div>
                        </div>
                    </div>    
                </div>
                <div class="copyright">复树文化出品</div>
            </div>
        </div>
        <!-- 提示框 -->
        <div class="modal" id="my-modal">
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
        <div class="modal" id="info-modal">
            <div class="info-con">
                <div class="title">
                    <div class="name pull-left">
                        <span>详情</span>
                    </div>
                    <div class="close pull-right">
                        <img class="close-con" src="images/close.png">
                    </div>
                </div>
                <div class="details">
                </div>
            </div>
        </div><!-- /.modal -->
        <div id="finance-info" style="display: none">
            <div class="finance-info">
                <div class="bg-img">
                    <img src="images/buy/bg.png">
                </div>
                <div class="text">
                    <div class="name">【官方付款账户】</div>
                    <p>
                        1. 一般户名：承瑾（上海）投资管理有限公司<br>
                        账户：5818 5194 6700 015<br>
                        开户银行：浙江民泰商业银行上海奉贤支行。<br>
                        2.招商银行上海分行浦东大道支行<br>
                        账户：6214 8512 1639 8045 <br>
                        户名：曾娟娟<br>
                        2.中国工商银行上海上师大支行<br>
                        账户：6222 0810 0102 7825 045<br>
                        户名：曾娟娟<br>
                    </p>
                </div>
            </div>
        </div>
        <div id="seat-detail-info" style="display: none">
            <div class="seat-detail-info">
                <div class="img-detail">
                    <img src="images/seat/img1.png">
                </div>
            </div>
        </div>
        <div name="buy" id="buy-btn" class=" text-center" style="display: none">
            <a class="btn">立即购票</a>
        </div>
    </div>
    <script src="js/jquery-1.9.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.rotate.min.js"></script>
    <script src="lib/pingpp.js"></script>
    <script src="js/jweixin.js"></script>
    <script src="js/main.js"></script>
    <script>
    $(function() {
        $("#buy-button").on("click", function() {
            var name = $("#confirm-name").html();
            var phone = $("#confirm-phone").html();
            var address = $("#confirm-address").html();
            // var address = "";
            var kind = $("#ticket-rank").val();
            var openid = "<?php echo $openid; ?>";
            var state = "<?php echo $state; ?>";
            var url = "payticket.php?name="+name+"&phone="+phone+"&address="+address+"&kind="+kind+"&openid="+openid+"&state="+state;
            var xhr = new XMLHttpRequest();
            xhr.open("POST", url, true);
            xhr.send(null);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var msg = xhr.responseText;
                    var jsons = eval("("+msg+")");
                    pingpp.createPayment(jsons.charge, function(result, err) {
                        if (result == "success") {
                            // 只有微信公众账号 wx_pub 支付成功的结果会在这里返回，其他的 wap 支付结果都是在 extra 中对应的 URL 跳转。
                            var ticket = jsons.charge.subject;
                            var body = jsons.charge.body.split(":");
                            name = body[0];
                            phone = body[1];
                            address = body[2];
                            $("#success-ticket").html($("#confirm .ticket").text());
                            $("#success-name").html(name);
                            $("#success-phone").html(phone);
                            $("#success-address").html(address);
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

    wx.config({
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: <?php echo $signPackage["timestamp"];?>,
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: [
            'onMenuShareTimeline', 'onMenuShareAppMessage', 'showMenuItems'
        ]
    });
    wx.onMenuShareTimeline({
        title: '2015中国企业家年会', // 分享标题
        link: 'http://mf23.cn/wx/php', // 分享链接
        imgUrl: 'http://mf23.cn/wx/php/images/logo_s.png', // 分享图标
        success: function () { 
            // 用户确认分享后执行的回调函数
        },
        cancel: function () { 
            // 用户取消分享后执行的回调函数
        }
    });
    wx.onMenuShareAppMessage({
        title: '2015中国企业家年会', // 分享标题
        desc: '2015中国企业家年会即将开始', // 分享描述
        link: 'http://mf23.cn/wx/php', // 分享链接
        imgUrl: 'http://mf23.cn/wx/php/images/logo_s.png', // 分享图标
        type: 'link', // 分享类型,music、video或link，不填默认为link
        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
        success: function () { 
            // 用户确认分享后执行的回调函数
        },
        cancel: function () { 
            // 用户取消分享后执行的回调函数
        }
    });
    document.querySelector('#showMenuItems').onclick = function () {
        wx.showMenuItems({
            menuList: [
                'menuItem:profile', 
                'menuItem:addContact', 
            ],
            success: function (res) {
                
            },
            fail: function (res) {
                
            }
        });
    };
    //wx.showAllNonBaseMenuItem();
    
    </script>
</body>
</html>


