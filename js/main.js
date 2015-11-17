function showModal(text) {
	$("#mymodal").modal("show");
	$("#mymodal .modal-body p").html(text);
	$("#mymodal button").click(function(){
		$("#mymodal").modal("hide");
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
		showModal("请选择一个席别");
		return false;
	} else if (!$("#form-name").val()) {
		showModal("请填写您的姓名");
		return false;
	} else if (!checkPhone($("#form-phone").val())) {
		showModal("请输入正确的手机号");
		return false;
	} else if (!$("#form-address").val()) {
		showModal("请填写您的地址");
		return false;
	} else {
		return true;
	}
}

$(function() {
	$(".con .close").on("click", function() {
		//close button clicked
		$(".con").addClass("low");
		$("#nav").fadeIn();
	});
	$("#nav a").on("click", function() {
		//nav button clicked
		$("#"+$(this).attr("name")).removeClass("low");
		$("#nav").fadeOut();
	});
	$("#seat a").on("click", function() {
		//go to buy page
		$("#seat").addClass("low");
		$("#"+$(this).attr("name")).removeClass("low");
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
	});
	$("#buy .choose .choose-btn").on("click", function() {
		if ($(this).hasClass("disabled")) {
			showModal("该席别已售完");
		} else if (!$(this).hasClass("choosen")) {
			// add green wrap to indicate choosen
			$("#buy .choose .choose-btn").removeClass("choosen");
			$(this).addClass("choosen");
			//set input hidden value
			$("#ticket-rank").val($(this).attr("rank"));
			$("#confirm .ticket").text($(this).text());
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

