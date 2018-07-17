$(function(){

});

function addToCart1(goodsId, parentId)

{

    //alert("in-------------addToCart1------------"+goodsId);

    var goods        = new Object();

    var spec_arr     = new Array();

    var fittings_arr = new Array();

    var number       = 1;

    var formBuy      = document.forms['ECS_FORMBUY'];

    var quick     = 0;

    // 检查是否有商品规格

    if (formBuy)

    {

        spec_arr = getSelectedAttributes(formBuy);

        if (formBuy.elements['number'])

        {

            number = formBuy.elements['number'].value;

        }

        quick = 1;

    }
    quick = 1;

    goods.quick    = quick;

    goods.spec     = spec_arr;

    goods.goods_id = goodsId;

    goods.number   = number;

    goods.parent   = (typeof(parentId) == "undefined") ? 0 : parseInt(parentId);


    Ajax.call('flow.php?step=add_to_cart1', 'goods=' + JSON.stringify(goods), addToCartResponse1, 'POST', 'JSON');

}

function addToCartResponse1(result)

{

    alert("in---addToCartResponse1------------");

    if (result.error > 0)

    {

        // 如果需要缺货登记，跳转

        if (result.error == 2)

        {

            if (confirm(result.message))

            {

                location.href = 'user.php?act=add_booking&id=' + result.goods_id + '&spec=' + result.product_spec;

            }

        }

        // 没选规格，弹出属性选择框

        else if (result.error == 6)

        {


            alert("in---addToCartResponse1----------22---------");

            openSpeDiv(result.message, result.goods_id, result.parent);

        }

        else

        {
            alert("in---addToCartResponse1----------33---------");
            alert(result.message);

        }

    }

    else

    {
        alert("in---addToCartResponse1----------44---------");

        var cartInfo = document.getElementById('ECS_CARTINFO');

        var cart_url = 'flow.php?step=cart';

        if (cartInfo)

        {

            cartInfo.innerHTML = result.content;

        }

        location.href = cart_url;

    }

}
/*******************************************************************************
 * 改变余额
 */
function useSurplus(val1, val2) {
	//Ajax.call('user.php?step=use_surplus', 'surplus=' + val, useSurplusResponse, 'GET', 'JSON');
	document.getElementById("surplus").value = val1;
	if( val1 >= val2 ){
		document.getElementById("b_money").innerHTML = 0;
		document.getElementById("amount").value = 0;
		document.getElementById("payment").style.display = "none"
		document.getElementById('ECS_SURPLUS').value = val2;
		document.getElementById("hidPayBank").value = "balance";
		document.getElementById("hidPayName").value = "4";
	}else{
		
		document.getElementById("b_money").innerHTML = val2 - val1;
		document.getElementById("amount").value = val2 - val1;
		document.getElementById('ECS_SURPLUS').value = val1;
	}
}

/*******************************************************************************
 * 改变余额回调函数
 */
function useSurplusResponse(obj) {
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
		orderSelectedResponse(obj.content);
	}
}