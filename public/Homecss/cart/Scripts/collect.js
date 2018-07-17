/**
 * 购物车
 * @version 1.0 上线版本号
 * log 购物车页推荐样式调整
 */
(function (window, $) {

    /**
     * 获取cookie
     **/
    function getCookie(name) {
        var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
        if (arr = document.cookie.match(reg))
            return unescape(arr[2]);
        else
            return null;
    }

    var config = {server: "http://recosys.dangdang.com/realdata/collect.jpg", intervalTime: 400, state: 'dev'};
    var MODULE = {
        cart_alsobuy: "cart_alsobuy",//购物车买了还买模块
        cart_foru: "cart_foru"//购物车为你推荐模块
    };
    var perm_id = getCookie("__permanent_id");//用户标识
    var main_pid = null;
    var alsobuy_timer = null;
    var alsobuy_list = null;
    var foru_timer = null;//为你推荐
    var foru_list = null;

    /**
     * 发送点击信息
     * @param strvalue
     */
    function report_click(strvalue) {
        strvalue = config.server + '?' + strvalue + '&type=1&random_id=' + Math.random();
        $(document.body).append("<img style=\"display: none;\" src=\"" + strvalue + "\"/>");
    }

    /**
     * 发送曝光数据
     * @param li 数据
     */
    function report(li) {
        var position = $(li).attr("position");
        var traced = $(li).attr("traced");
        if (position != null && traced != 1) {
            var src = config.server + "?" + position + "&type=0&random_id=" + Math.random();
            $(document.body).append("<img style=\"display: none;\" src=\"" + src + "\"/>");
            $(li).attr("traced", 1)
        }
    }

    function report_list(li_list) {
        for (var i = 0; i < li_list.length; i++) {
            var position = $(li_list[i]).attr("position");
            var traced = $(li_list[i]).attr("traced");
            if (position != null && traced != 1) {
                var src = config.server + "?" + position + "&type=0&random_id=" + Math.random();
                $(document.body).append("<img style=\"display: none;\" src=\"" + src + "\"/>");
                $(li_list[i]).attr("traced", 1); //曝光标记
            }
        }
    }

    /*alsobuy可见区域*/
    function get_alsobuy_visible_list() {
        var ul_list = $("#J_alsobuy").find("ul.show_box");
        for (var i = 0; i < ul_list.length; i++) {
            var display = $(ul_list[i]).css('display');
            if (display != 'none') {
                return ul_list[i];
            }
        }
    }

    /**
     * 监测是否进入可视区
     * @param ul
     * @param clientHeight
     * @param scrollTop
     */
    function trace(ul, clientHeight, scrollTop) {
        if (ul != null) {
            var li_list = $(ul).find("li");
            if (li_list != null && li_list.length > 0) {
                for (var i = 0; i < li_list.length; i++) {
                    var offsetTop = $(li_list[i]).offset().top;
                    var height = $(li_list[i]).height();
                    if (offsetTop < scrollTop) {
                        //已经滚动到可视取上方
                        if ((offsetTop + height) > scrollTop && (offsetTop + height) < (clientHeight + scrollTop)) {
                            //露出尾部
                            report(li_list[i]);
                            $(ul).attr("traced", 1);
                        } else if ((offsetTop + height) < scrollTop) {
                            //上方不可见位置
                        }
                    } else if (offsetTop < clientHeight + scrollTop) {
                        //进入可视区
                        report(li_list[i]);
                        $(ul).attr("traced", 1);
                    } else {
                        //在可视区下方
                    }
                }
            }
        }

    }

    /**
     * alsobuy分页触发事件
     */
    function trace_alsobuy_page() {
        var ul = get_alsobuy_visible_list(); //获取可见的图书页
        var clientHeight = $(window).height();
        var scrollTop = $(document).scrollTop();
        trace(ul, clientHeight, scrollTop);
    }

    /*买了还买模块监控*/
    function test_alsobuyData() {
        var alsobuy_div = $("#J_alsobuy");
        alsobuy_list = $(alsobuy_div).find("ul.show_box.line2 li");
        if (alsobuy_list.length > 0) {
            var request_id = $($(alsobuy_div).find("ul.show_box.line2:first")).attr("request_id");
            for (var i = 0; i < alsobuy_list.length; i++) {
                var url = $(alsobuy_list[i]).find("a.gpic").attr("href");
                if (url == null){
                    continue;
                }
                var reco_pid = /\d+/.exec(url)[0];
                var position = i + 1;
                var params = {
                    request_id: request_id,
                    perm_id: perm_id,
                    module: MODULE.cart_alsobuy,
                    main_pid: 0,
                    reco_pid: reco_pid,
                    position: position,
                    state: config.state,
                    client: "PC"
                };
                var paramsstr = $.param(params);
                $(alsobuy_list[i]).attr("position", paramsstr);

                //添加点击事件
                $(alsobuy_list[i]).find("a").click(function () {
                    //购物车页商品展示元素不统一
                    var position = $(this).parent().attr("position");
                    if (position == null) {
                        position = $($(this).parent()).parent().attr("position");
                    }
                    report_click(position);
                })
            }

            //添加分页事件
            var prev = $(alsobuy_div).find("a.arrow.left").click(function () {
                setTimeout(trace_alsobuy_page, 400);
            });
            var next = $(alsobuy_div).find("a.arrow.right").click(function () {
                setTimeout(trace_alsobuy_page, 400);
            });
            var topage = $(alsobuy_div).find("ul.ads_num li").click(function () {
                setTimeout(trace_alsobuy_page, 400);
            });

            //第一页曝光
            var clientHeight = $(window).height();
            var scrollTop = $(document).scrollTop();
            var ul = get_alsobuy_visible_list();
            trace(ul, clientHeight, scrollTop);
            clearInterval(alsobuy_timer);

            //添加滚动事件
            $(window).scroll(function () {

                var clientHeight = $(window).height();
                var scrollTop = $(document).scrollTop();
                var ul = get_alsobuy_visible_list();
                trace(ul, clientHeight, scrollTop);
            });


        }

    }


    /**
     * 为你推荐分页触发事件
     */
    function trace_foru_page() {

        var ul = get_foru_visible_list(); //获取可见的模块
        var clientHeight = $(window).height();
        var scrollTop = $(document).scrollTop();
        trace(ul, clientHeight, scrollTop);
    }


    /*为你推荐可见区域*/
    function get_foru_visible_list() {
        var ul_list = $("#J_weinituijian").find("ul.show_box");
        for (var i = 0; i < ul_list.length; i++) {
            var display = $(ul_list[i]).css('display');
            if (display != 'none') {
                return ul_list[i];
            }
        }
    }

    /*为你推荐监控*/
    function test_foruData() {
        var foru_div = $("#J_weinituijian");
        foru_list = $(foru_div).find("ul.show_box li");
        if (foru_list.length > 0) {
            var request_id = $($(foru_div).find("ul.show_box:first")).attr("request_id");
            for (var i = 0; i < foru_list.length; i++) {
                var url = $(foru_list[i]).find("a.gpic").attr("href");
                if (url == null){
                    continue;
                }
                var reco_pid = /\d+/.exec(url)[0];
                var position = i + 1;
                var params = {
                    request_id: request_id,
                    perm_id: perm_id,
                    module: MODULE.cart_foru,
                    main_pid: 0,
                    reco_pid: reco_pid,
                    position: position,
                    state: config.state,
                    client: "PC"
                };
                var paramsstr = $.param(params);
                $(foru_list[i]).attr("position", paramsstr);

                //添加点击事件
                $(foru_list[i]).find("a").click(function () {
                    var position = $(this).parent().attr("position");
                    if (position == null) {
                        position = $($(this).parent()).parent().attr("position");
                    }
                    report_click(position);
                })
            }

            //添加分页事件
            var prev = $(foru_div).find("a.arrow.left").click(function () {
                setTimeout(trace_foru_page, 400);
            });
            var next = $(foru_div).find("a.arrow.right").click(function () {
                setTimeout(trace_foru_page, 400);
            });
            var topage = $(foru_div).find("ul.ads_num li").click(function () {
                setTimeout(trace_foru_page, 400);
            });

            //第一页曝光
            var clientHeight = $(window).height();
            var scrollTop = $(document).scrollTop();
            var ul = get_foru_visible_list();
            trace(ul, clientHeight, scrollTop);
            clearInterval(foru_timer);

            //添加滚动事件
            $(window).scroll(function () {

                var clientHeight = $(window).height();
                var scrollTop = $(document).scrollTop();
                var ul = get_foru_visible_list();
                trace(ul, clientHeight, scrollTop);
            });


        }

    }


    function cart_start() {
        //买了还买监控
        alsobuy_timer = setInterval(test_alsobuyData, config.intervalTime);
        //为你推荐监控
        foru_timer = setInterval(test_foruData, config.intervalTime);
    }

    window.CC = {
        cart: function () {
            cart_start();
        }
    }
})(window, jQuery);
