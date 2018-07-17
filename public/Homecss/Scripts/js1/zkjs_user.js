$(function(){
	// 充值弹出窗口开始
	
	$('.chongzhi').click(function(){
               
		// top的值＝浏览器可视区域的宽度／2－弹出窗口的宽度／2
		var left01 = ($(window).width()/2) - ($('.zk_hide').outerWidth(true)/2);
		// 设置窗口Top和Lfet值。
		$('.zk_hide').css('top',120);
		$('.zk_hide').css('left',left01);
		// 显示窗口
		$('.zk_hide').show();	
		// 添加遮罩层
		$('body').append('<div class="zk_msak"></div>');

	});

	$('.zk_close').click(function(){
		// 关闭窗口
		$('.zk_hide').hide();
		$('.zk_msak').remove();
	});

	//我的钱包表格隔行变色
	$('#cp-orderlist .coupon-tablist .coupon-list:odd').css('background','#fbfbfb');

	//订单详情页相关
	
})
