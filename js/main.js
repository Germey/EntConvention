function showModal(text) {
	$("#my-modal").modal("show");
	$("#my-modal .modal-body p").html(text);
	$("#my-modal button").click(function(){
		$("#my-modal").modal("hide");
	});
}

//设置旋转
function rotatePic(ele, timeout, angle) {
	if (timeout) {
		setTimeout(function(){
			ele.rotate({
				angle:0, 
				animateTo: angle,
				easing: function (x,t,b,c,d) {
		        	return c*(t/d)+b;
		        }
			});
		}, timeout);
	} else {
		ele.rotate({
			angle:0, 
			animateTo:angle,
			easing: function (x,t,b,c,d) {
	        	return c*(t/d)+b;
	        }
		});
	}
}

//显示详情页面，比如座位图放大，汇款信息详情
function showDetailInfo(value) {
	switch (value) {
		case 1:
			//汇款信息
			$("#info-modal .details").html($("#finance-info").html());
			//底层背景大小适配
			//$(".info-con .finance-info .bg-img img").height($(".info-con .finance-info .text").height() + 100);
			break;
		case 2:
			//座位放大图
			$("#info-modal .details").html($("#seat-detail-info").html());
			break;
	}
	$("#info-modal").modal("show");
	$("#info-modal .close").click(function() {
		$("#info-modal").modal("hide");
	});
}

function checkPhone(value) {
	if ((value.length != 11) || (!value.match(/^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|17[0|6|7|8]|18[0-9])\d{8}$/))) {
		return false;
	 } else {
		return true;
	}
}

function judgeInfo() {
	if (!$("#ticket-rank").val()) {
		//showModal("请选择一个席别");
		alert("请选择一个席别");
		return false;
	} else if (!$("#form-name").val()) {
		//showModal("请填写您的姓名");
		alert("请填写您的姓名");
		return false;
	} else if (!checkPhone($("#form-phone").val())) {
		//showModal("请输入正确的手机号");
		alert("请输入正确的手机号");
		return false;
	} else if (!$("#form-address").val()) {
		//showModal("请填写您的地址");
		alert("请填写您的地址");
		return false;
	} else {
		return true;
	}
}

$(function() {
	var dark_bg = "images/bg_dark.png";
	//$("#confirm").removeClass("low");
	//$("#success").removeClass("low");
	//$("#nav").fadeIn();
	//$("#info-modal").modal("show");
	$(".con .close").on("click", function() {
		//close button clicked
		$(".con").addClass("low");
		$("#nav").fadeIn();
		$("#buy-btn").fadeOut();
		$(".bg img").attr("src", "images/bg.png");
		rotatePic($(this).find("img"), 0, 720);
	});
	$("#nav a").on("click", function() {
		if ($(this).attr("name") == "intro" || $(this).attr("name") == "guest" || $(this).attr("name") == "focus") {
			$("#buy-btn").fadeIn();
		}
		//nav button clicked
		$("#"+$(this).attr("name")).removeClass("low");
		$("#nav").fadeOut();
		$(".bg img").attr("src", dark_bg);
		rotatePic($("#"+$(this).attr("name")).find(".close img"), 1000, 360);
	});
	$("#seat a").on("click", function() {
		//go to buy page
		$("#seat").addClass("low");
		$("#"+$(this).attr("name")).removeClass("low");
		rotatePic($("#"+$(this).attr("name")).find(".close img"), 1000, 360);
	});
	$("#to-confirm").on("click", function() {
		if (judgeInfo()) {
			//go to buy page
			$("#confirm-name").html($("#form-name").val());
			$("#confirm-phone").html($("#form-phone").val());
			$("#confirm-address").html($("#form-address").val());
			$("#buy").addClass("low");
			$("#confirm").removeClass("low");
		}
	});
	$("#back-to-edit").on("click", function() {
		$("#confirm").addClass("low");
		$("#buy").removeClass("low");
		rotatePic($("#buy").find(".close img"), 1000, 360);
	});
	$("#buy .choose .choose-btn").on("click", function() {
		if ($(this).hasClass("disabled")) {
			//showModal("该席别已售完");
			alert("该席别已售完");
		} else if (!$(this).hasClass("choosen")) {
			// add green wrap to indicate choosen
			$("#buy .choose .choose-btn").removeClass("choosen");
			$(this).addClass("choosen");
			//set input hidden value
			$("#ticket-rank").val($(this).attr("rank"));
			var confirm_text = $(this).find("span").text();
			//如果是私董席，体现价格
			if ($(this).attr("rank") == 1) {
				confirm_text += "：29999";
			}
			$("#confirm .ticket").text(confirm_text);
		}
	});
	$("#seat-img").on("click", function() {
		//座位放大
		showDetailInfo(2);
	});
	$("#finance-btn").on("click", function() {
		//汇款详情
		showDetailInfo(1);
	});
	//悬浮购买按钮，只在某些介绍页面出现
	$("#buy-btn").on("click", function() {
		$(".con").addClass("low");
		$("#"+$(this).attr("name")).removeClass("low");
		$(this).fadeOut();
		rotatePic($("#"+$(this).attr("name")).find(".close img"), 1000, 360);
	});
	$("#nav-copy").fadeIn();
	$("#guest .content .col").each(function() {
		var thisHeight = $(this).height();
		var sibHeight = $(this).siblings().height();
		if (sibHeight > thisHeight) {
			$(this).height(sibHeight);
		}
	});
});

/*
$(function() {
	var text = '{"id":"evt_9xfHv2n9KTr3U5WJXmzRgRDO","created":1447770713,"livemode":false,"type":"charge.succeeded","data":{"object":{"id":"ch_WznTG0S4uzn5q5Sm1GSuvLKO","object":"charge","created":1447770628,"livemode":false,"paid":true,"refunded":false,"app":"app_90iv9CinvL40yDWT","channel":"wx_pub","order_no":"e71e5cd119bbc5798CrCPC3FK6wmz4xU","client_ip":"101.226.89.14","amount":139900,"amount_settle":0,"currency":"cny","subject":"2015中国企业家年会白金席","body":"崔庆才:18366119732:喝个","extra":{"open_id":"wxopenid12345678901234567890","bank_type":"your bank type"},"time_paid":1447770713,"time_expire":1447772428,"time_settle":null,"transaction_no":"1248785589201511176211862473","refunds":{"object":"list","url":"/v1/charges/ch_WznTG0S4uzn5q5Sm1GSuvLKO/refunds","has_more":false,"data":[]},"amount_refunded":0,"failure_code":null,"failure_msg":null,"metadata":{},"credential":{},"description":null}},"object":"event","pending_webhooks":0,"request":"iar_uvH0C0L8SKi9qrrbP0ivz1mL"}';
	alert(text);
	var jsons = JSON.parse(text);
	alert(jsons.data.object.subject);
});
*/

