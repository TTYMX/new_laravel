window.JSON?jQuery.JSON=window.JSON:jQuery.JSON={parse:function(t){return new Function("return "+t)()},stringify:function(t){if(t instanceof Object){var e="";if(t.constructor===Array){for(var a=0;a<t.length;e+=this.stringify(t[a])+",",a++);return"["+e.substr(0,e.length-1)+"]"}if(t.toString!==Object.prototype.toString)return'"'+t.toString().replace(/"/g,"\\$&")+'"';for(var o in t)e+='"'+o.replace(/"/g,"\\$&")+'":'+this.stringify(t[o])+",";return"{"+e.substr(0,e.length-1)+"}"}return"string"==typeof t?'"'+t.replace(/"/g,"\\$&")+'"':String(t)}},function(t){function e(){function e(e){var a=t(".cart-goods"),o={marketType:"market_meilishuo",topNum:5};t.ajax({url:"http://cart.meilishuo.com/api/cart/miniCartList",data:o,dataType:"jsonp"}).then(function(o){if("1001"==o.status.code){var n="",s=o.result.cartItems?o.result.cartItems.length:0,i=Math.min(5,s);if(i>0){t(".cart-wrapper .hidden").addClass("down").removeClass("hidden"),e();for(var c=0;c<i;c++){for(var r=o.result.cartItems[c],l="",u=0,d=r.skuAttributes.length;u<d;u++){var p=r.skuAttributes[u];l+="<span>"+p.key+":"+p.value+"</span>&nbsp;&nbsp;"}n+='<li><a href="http://item.meilishuo.com/detail/'+r.itemIdEsc+'" target="_blank" style="padding: 0; float: left;"><span class="cart-goods-img" style="background: url('+r.imgUrl+') no-repeat; background-size: cover;"></span></a><div class="cart-goods-desc"><p><a href="http://item.meilishuo.com/detail/'+r.itemIdEsc+'" target="_blank" style="padding: 0; float: left;"><span class="cart-goods-title">'+r.title+'</span></a><span class="cart-goods-price">￥'+r.nowprice/100+'</span></p><p class="cart-goods-info"><span class="cart-goods-title">'+l+'</span><em class="del-cart-goods" data-stock="'+r.stockIdEsc+'"></em></p></div></li>'}a.html(n)}}})}function a(){t.ajax({url:"http://cart.meilishuo.com/api/cart/getItemCount",data:{marketType:"market_meilishuo"},dataType:"jsonp"}).then(function(e){var a=e.status,o=e.result.count>99?"99+":e.result.count;a.isLogin&&"1001"==a.code&&0!=o&&(t(".cart .hidden").addClass(".down").removeClass(".hidden"),t(".my-cart").append('<span class="cart-num">'+o+"</span>"),t(".cart-account .num").text(o))})}function o(){e(a),t("#com-topbar").on("click",".del-cart-goods",function(){var e=t(this).closest("li"),a=t(this).closest(".down"),o=t(this).data("stock");t.ajax({url:"http://cart.meilishuo.com/api/cart/deleteCart",data:{marketType:"market_meilishuo",stockId:o},dataType:"jsonp"}).then(function(t){e.remove();var o=a.find(".cart-goods li").length;o||a.remove()})})}o()}function a(){function e(t){t=t.list;for(var e="",a=0;a<t.length;a++){var o=t[a];e+='<a target="_blank" href="http://www.meilishuo.com/search/goods/?page=1&searchKey='+encodeURIComponent(o.word)+'" style="color:'+o.color+'">'+o.word+"</a >"}d.html(e)}function a(t){t&&t.list&&t.list.length&&(t=t.list[0],u.attr({placeholder:t.placehold,"data-placeholder":t.placehold,"data-key":t.word}))}function o(){t.ajax({url:"http://mce.mogucdn.com/jsonp/multiget/3?pids=5604,5571",dataType:"jsonp"}).then(function(t){t.success&&(e(t.data[5571]),a(t.data[5604]))})}function n(t){var e=/(?:&|\?)searchKey=([^&]+)/.exec(location.search);e&&e[1]&&u.val(decodeURI(e[1]));var a=/(?:&|\?)filter=([^&]+)/.exec(location.search);a=a&&a[1],"shop"==a&&s(p.find("span")[1])}function s(e){t(e).is("span")&&(p.find("span").removeClass("active"),t(e).addClass("active"),f=t(e).index(),u.attr("placeholder",0==f?u.attr("data-placeholder"):""))}function i(){if(0==f){var e=t.trim(t(this).val());if(e){if(g.lastVal==e)return void m.show();g.lastVal=e,g.cache[f]=g.cache[f]||{};var a=g.cache[f];clearTimeout(g.delayId),g.delayId=setTimeout(function(){a[e]?g.render(a[e]):t.ajax({url:g.url,data:{data:'{"keyword":"'+encodeURIComponent(e)+'"}'},dataType:"jsonp"}).then(function(t){a[e]=t,g.render(a[e])})},g.delayTime)}}}function c(e){var a=t(".active",m).removeClass("active");a.length?"up"==e?(a=a.prev(),a.length||(a=m.find(".item").last())):(a=a.next(),a.length||(a=m.find(".item").first())):a=m.find(".item").first(),a.addClass("active"),u.val(a.attr("data-title"))}function r(e){if(e=0==f?t.trim(e)||t.trim(u.attr("data-key")):t.trim(e)){var a=(encodeURIComponent(e),"http://www.meilishuo.com/search/goods/?page=1&searchKey="+encodeURIComponent(e));0!=f&&(a="http://www.meilishuo.com/search/shop/"+encodeURIComponent(e)+"?filter=shop"),location.href=a}}function l(){n(),o(),p.click(function(t){s(t.target)}),v?u.on("input",function(){i.call(this)}):u.on("propertychange",function(){i.call(this)}),u.on("blur",function(){setTimeout(function(){m.hide()},250)}).on("focus",function(){i.call(this)}).on("keyup",function(t){var e=t.keyCode;if(38==e||40==e){var a=38==e?"up":"down";c(a)}else 13==e&&r(this.value)}),m.on("mouseover",function(e){t(".item",this).removeClass("active"),t(e.target).closest(".item").addClass("active")}).on("click",function(e){var a=t(".active",this).attr("data-title"),o=e.target;r("span"==o.tagName.toLowerCase()?a+" "+t(o).text():a)}),h.on("click",function(){r(u.val())})}var u=t(".search-txt"),d=t(".hotword"),p=t(".search-tab"),m=t(".suggest-box"),h=t(".search-btn"),f=0,v="oninput"in document,g={lastVal:null,delayId:null,cache:{},url:"http://search.mogujie.com/jsonp/searchTipsMLS/1",delayTime:500,render:function(t){if(t&&t.success){for(var e=t.data.tips,a="",o=0;o<e.length;o++){for(var n=e[o].props,s="",i=0;i<n.length;i++)s+="<span>"+n[i].title+"</span>";a+='<div class="item" data-title="'+e[o].title+'">'+e[o].title+'<div class="tags">'+s+"</div></div>"}m.html(a).show()}else m.hide()}};l()}function o(){var e=t(".sec_attr .list");t(".nav_list");e.hover(function(){var a=t(this).children(".nav_list");0!=a.length&&(e.removeClass("active"),t(this).addClass("active"),a.show())},function(){e.removeClass("active"),t(this).removeClass("active"),t(this).children(".nav_list").hide()});var a=e.length;e.each(function(e){e==a-1&&t(this).addClass("last")});var o=t(".attr_box");"/welcome"==location.pathname?o.css("display","block"):t(".all , .attr_box").hover(function(){o.stop(!0,!0).slideDown()},function(t){t.stopPropagation(),o.find(".nav_list").hide(),o.stop(!0,!0).slideUp()});var n={"/welcome":"首页","/brand/street":"品牌街","/daimaiPCrukou":"官网直邮","/select":"好物"},s="",i=location.pathname;t.each(n,function(t,e){if(0==i.indexOf(t))return s=n[t],!1}),"/"==i&&(s="首页");var c=t(".nav_tab");c.each(function(){var e=t(this).find("a").html();s==e&&t(this).find("a").addClass("active")})}function n(){var e=function(){function e(){a.css("height",t(document).height()+"px")}var a=t(".biu-sidebar"),o=t(".biu-download"),n=t(".mls-qrcode");if(e(),t(window).resize(function(){e()}),o.hover(function(){n.css("display","block")},function(){n.css("display","none")}),t(window).scroll(function(){document.body.scrollTop?document.body.scrollTop>0?t(".biu-go2top").css("display","block"):t(".biu-go2top").css("display","none"):document.documentElement.scrollTop&&document.documentElement.scrollTop>0?t(".biu-go2top").css("display","block"):t(".biu-go2top").css("display","none")}),t(".biu-go2top").on("click",function(){window.scrollTo(0,0)}),t.ajax({type:"get",url:"http://cart.meilishuo.com/api/cart/getItemCount?marketType=market_meilishuo",dataType:"jsonp",success:function(e){var a=e||{};1001==a.status.code&&a.result&&a.result.count>0&&(a.result.count>99?t(".biu-cart-num").text("99+"):t(".biu-cart-num").text(a.result.count))},error:function(){console.log("--右侧栏 jsonp请求购物车商品数出错")}}),t.ajax({type:"get",url:"http://promotionnew.meilishuo.com/jsonp/getUnUsedCouponNumber/1?domain=11",dataType:"jsonp",success:function(e){var a=e||{};a.success&&a.data.number>0&&(a.data.number>99?t(".biu-coupon-num").text("99+"):t(".biu-coupon-num").text(a.data.number))},error:function(){console.log("--右侧栏 jsonp请求优惠券数出错")}}),location.href.indexOf("act.meilishuo.com")!=-1||location.href.indexOf("1111.meilishuo.com")!=-1)t(".biu-service").hide();else{var s=t(".biu-login").text(),i=""==s||"0"==s||null==s&&void 0!=s||" "==s;!i&&t.ajax({type:"get",url:"http://webim.meilishuo.com/jsonp/cinfo/1",dataType:"jsonp",success:function(e){var a=e||{};a.success&&a.data>0&&t(".biu-service-num").text(a.data)},error:function(t,e){console.log("--右侧栏 jsonp请求客服消息数出错")}});var c=document.head||document.getElementsByTagName("body")[0],r=document.createElement("script");r.src="//s10.mogucdn.com/~mls-node-open-im/assets/0.0.1/openIm.js",c.appendChild(r),t(".biu-open-im").on("click",function(){var e=t(".biu-login").text();return""==e||"0"==e||null==e&&void 0!=e||" "==e?(console.log(e),window.open("/user/login"),!1):(window._openIm(e,""),!1)})}};e.prototype.biuAddCart=function(e){t.ajax({type:"get",url:"http://cart.meilishuo.com/api/cart/getItemCount?marketType=market_meilishuo",dataType:"jsonp",jsonp:"biuCartNum",success:function(a){var o=a||{};if(1001==o.status.code&&o.result&&o.result.count>0){var n=o.result.count+e;n>0&&n<100?t(".biu-cart-num").text(n):t(".biu-cart-num").text("99+")}}})};new e}function s(t){var e=document.head||document.getElementsByTagName("head")[0],a=document.createElement("style");a.type="text/css",a.styleSheet?a.styleSheet.cssText=t:a.appendChild(document.createTextNode(t)),e.appendChild(a)}var i,c=function(e){s(e.css),i.topbar&&t("#topbar").html(e.topbar),i.search&&t("#search").html(e.search),i.nav&&t("#nav").html(e.nav),i.foot&&t("#foot").html(e.foot)};t.blast=function(s){i=s,t.ajax({url:"http://www.meilishuo.com/api/blast",data:{conf:t.JSON.stringify(i)},dataType:"jsonp",jsonp:"sdback",jsonpCallback:"cbk"}).then(function(t){c(t),e(),a(),o(),n()})}}(jQuery);;