@include('/home/layout/top')
<title>商品详情页面</title>
</head>
<body>
    <div class="row" style="position:absolute;left:35%;top:80px; width:50%;">
        <div class="col-lg-6 col-lg-offset-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissable">
                    {{session('success')}}
                    <button type="" class="close" data-dismiss="alert" aria-label="Close">
                        &times;
                    </button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissable">
                    {{session('error')}}
                    <button type="" class="close" data-dismiss="alert" aria-label="Close">
                        &times;
                    </button>
                </div>
            @endif
        </div>
    </div>
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
    <button type="button" buy="0" class="btn me btn-warning" id="addCard">加入购物车</button>
    <button type="button" buy="1" class="btn me btn-success" id="buyNow">立即购买</button>
    <a href="{{url('home/card/list')}}"><button class="btn">前往购物车</button></a>

    <script type="text/javascript">
        $(function(){
            var total = "{{$good->total}}";
            var id = "{{$good->id}}";
            $('.me').click(function(){
                if (total > 0) {
                    if (parseInt($(this).attr('buy'))){
                        //执行购买操作
                        location.href = "{{url('home/card/buy?id='.$good->id)}}"
                    } else {
                        //执行添加购物车操作
                        $.ajax({
                            type: 'GET',
                            url: '/home/card/card',
                            data: {'good_id': id},
                            success: function (data) {
                                location.href='';
                                if (!data.errcode) {
                                    alert(data.msg)
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