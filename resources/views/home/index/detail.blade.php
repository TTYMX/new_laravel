@include('/home/layout/top')
<title>商品详情页面</title>
</head>
<body>
    <div>
        <img src="{{url($pic->path)}}" height="300" alt="">
    </div>
    <div>
        <h3>价格:{{$good->price}}</h3>
        <h3>名称:{{$good->name}}</h3>
        <h3>描述:{{strip_tags($good->content) ? strip_tags($good->content) : '暂无'}}</h3>
        <h3>库存:<?php if ($good->total>0) {
                echo '<span style="color:blue;">'.$good->total.'</span>';
            } else {
                echo '<span style="color:red;">'.$good->total.'</span>';
            } ?></h3>
    </div>
    <button type="button" buy="0" class="btn btn-warning" id="addCard">加入购物车</button>
    <button type="button" buy="1" class="btn btn-success" id="buyNow">立即购买</button>
    <a href="{{url('home/index/card')}}"><button class="btn">前往购物车</button></a>

    <script type="text/javascript">
        $(function(){
            var total = "{{$good->total}}";
            var id = "{{$good->id}}";
            $('.btn').click(function(){
                if (total > 0) {
                    if (parseInt($(this).attr('buy'))){
                        //执行购买操作
                        location.href = "{{url('home/card/buy?id='.$good->id)}}"
                    } else {
                        //执行添加购物车操作
                        $.ajax({
                            type: 'POST',
                            url: '/home/index/card',
                            data: {'id': id},
                            success: function (data) {
                                if (!data.errcode) {
                                    btn.parents('tr').remove();
                                } else {
                                    alert(data.msg);
                                }
                            },
                            dataType: 'json'
                        });
                    }
                } else {
                    alert('卖完了');
                }
            })
        });
    </script>
@include('/home/layout/bottom')