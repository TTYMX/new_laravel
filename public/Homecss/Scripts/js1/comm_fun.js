$(document).ready(function(){
var j = "";
var c = $("#submit_ok");
var f = $("#b_money");
var h = $("#txtOtherMoney");
var i = $("#div_platform");
var d = $("#div_savings");
var m = function(o, p) {
	var n = function() {
		$("#btnToRecharge", "#pageDialog").bind("click",
		function() {
			$.cookie("recharge", 1);
			location.href = "/UserBalance.do";
			return false
		});
		$("#btnReSelect", "#pageDialog").bind("click",
		function() {
			$.PageDialog.close();
			return false
		})
	};
	$.PageDialog($("#payAltBox").html(), {
		W: 388,
		H: 247,
		ready: n
	})
};
var g = function(n) {

	m()
};
$("#ul_menu").children("li").each(function(n) {
	$(this).bind("click",
	function() {
		$(this).addClass("curr").siblings().removeClass("curr");
		if (n == 0) {
			i.show();
			d.hide();
		} else {
			if (n == 1) {
				i.hide();
				d.show();
			}
		}
	})
});
$("input[name=account]").each(function() {
	$(this).bind("click",
	function() {
		$("input[name=account]").parent().removeClass("checked");
		$(this).parent().addClass("checked");
		j = $(this).val();
		if (/^\d{1,2}$/.test(j)) {
			$("#hidPayName").val(j);
			$("#hidPayBank").val("0")
		} else {
			$("#hidPayName").val("3");
			$("#hidPayBank").val(j)
		}
	})
});
$("#ulMoneyList").children("li").each(function() {
	$(this).click(function() {
		$(this).addClass("f-checked").siblings().removeClass("f-checked");
		var o = parseInt($(this).attr("money"));
		if (o == 0) {
			h.focus();
			var n = h.val();
			if (parseInt(n) > 0) {
				f.html(n);
				$("#hidMoney").val(n);
			} else {
				h.val("");
				f.html(0);
			}
		} else {
			f.html(o);
			h.val("");
			$("#hidMoney").val(o);
		}
	})
});
var e = function() {
	var n = h.val();
	if (n == "") {
		f.html(0)
		$("#hidMoney").val(0);
	} else {
		if (isNaN(parseInt(n)) || parseInt(n) == 0) {
			if (f.html() == "0") {
				h.val("")
				$("#hidMoney").val(0);
			} else {
				h.val(f.html())
				$("#hidMoney").val(f.html());
			}
		} else {
			f.html(parseInt(n))
			$("#hidMoney").val(parseInt(n));
		}
	}
};
h.focus(function() {
	$(this).parent().addClass("f-checked").siblings().removeClass("f-checked")
}).keyup(function(o) {
	e();
	var n = (window.event) ? event.keyCode: o.keyCode;
	if (n == 13) {
		c.focus()
	}
	if ($(this).val().trim() == "") {
		$(this).css("font-size", "16px")
	}
}).keydown(function() {
	$(this).css("font-size", "18px")
});
var k = false;
c.click(function() {
	var o = f.html();
/*	if (isNaN(parseInt(o)) || parseInt(o) <= 0) {
		FailDialog("请选择或输入充值金额！");
		return false
	}
	$("input[name=account]").each(function(p, q) {
		if ($(q).attr("checked") == true) {
			k = true;
			j = $(this).val()
		}
	});
	if (k == false) {
		FailDialog("请选择支付方式！");
		return false
	}*/
	g(o);
	return j != ""
})
});

function queryByStatus(a){
	if(a=="all"){
		$("#selectedStatus").text("全部");
		$("#transStatus").val("");$("#tab_all").addClass("act-state");
		$("#tab_waitPay").removeClass("act-state");
		$("#tab_waitReceive").removeClass("act-state")
	}
	else{
		if(a=="waitPay"){
			$("#selectedStatus").text("待支付");
			$("#transStatus").val("waitPay");
			$("#tab_all").removeClass("act-state");
			$("#tab_waitPay").addClass("act-state");
			$("#tab_waitReceive").removeClass("act-state")
		}
		else{
			if(a=="waitReceive"){
				$("#selectedStatus").text("待收货");
				$("#transStatus").val("waitReceive");
				$("#tab_all").removeClass("act-state");
				$("#tab_waitPay").removeClass("act-state");
				$("#tab_waitReceive").addClass("act-state")
			}
			else{
				if(a=="waitPickup"){
					$("#selectedStatus").text("待自提");
					$("#transStatus").val("waitPickup")
				}
				else{
					if(a=="cancel"){
						$("#selectedStatus").text("已取消");
						$("#transStatus").val("cancel")
					}
					else{
						if(a=="success"){
							$("#selectedStatus").text("已完成");
							$("#transStatus").val("success")
						}
						else{
							if(a=="return"){
								$("#selectedStatus").text("已退货");
								$("#transStatus").val("return")
							}
						}
					}
				}
			}
		}
	}
	$("#sn_beginTime").val("");
	$("#sn_endTime").val("");
	$("#time3month").removeClass("act-date");
	$("#time1year").removeClass("act-date");
	$("#timeAll").addClass("act-date");
	$("#pageNumber").val("1");
	if(a=="waitPay"||a=="waitReceive"){
		$("#queryConditionText").val("");
		$("#conditionDiv").hide()
	}else{
		$("#conditionDiv").show();
		$("#tab_all").addClass("act-state");
		$("#tab_waitPay").removeClass("act-state");
		$("#tab_waitReceive").removeClass("act-state")
	}
	doPageQuery()
}

/*******************************************************************************
 * 改变余额
 */
function changeSurplus(val) {
	/* 代码增加_start By www.68ecshop.com */
	var con_country = document.forms['theForm'].elements['have_consignee'].value;
	if (con_country == '0') {
		alert('请先选择配送地址！');
		obj.checked = false;
		return;
	}
	/* 代码增加_end By www.68ecshop.com */

	if (selectedSurplus == val) {
		// return;
	} else {
		// selectedSurplus = val;
	}

	Ajax.call('flow.php?step=change_surplus', 'surplus=' + val, changeSurplusResponse, 'GET', 'JSON');
}

/*******************************************************************************
 * 改变余额回调函数
 */
function changeSurplusResponse(obj) {
	if (obj.error) {
		try {
			alert(obj.error);
			document.getElementById('ECS_SURPLUS').value = '0';
			document.getElementById('ECS_SURPLUS').focus();
		} catch (ex) {
		}
	} else {
		try {
			document.getElementById('ECS_SURPLUS').value = obj.surplus;
			if(obj.show){
				//如果余额完全支付订单金额
				$('#pay_div').hide();
				$('#payment_other_input').attr("checked", true).val(pay_balance_id);//默认选择余额支付方式
			}else{
				$('#pay_div').show();
				$("input[type='radio']").attr("checked", false);//将之前选择的支付方式去掉
				$('#payment_other_input').val('0');
			}
		} catch (ex) {
		}
	}
}

function copyTxt(){
	//var m = $(this);
	var l = $("#txtInfo");
	if(/msie/.test(navigator.userAgent.toLowerCase())){
		window.clipboardData.clearData();
        window.clipboardData.setData("Text", l.val().trim());
		alert("复制成功!");
	} else {
		alert("对不起，您使用的是非IE核心浏览器，请手动复制内容。");
		l.focus().select()
	}
}