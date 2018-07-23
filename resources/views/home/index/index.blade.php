<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>首页</title>
    <style>
        .container-fluid {
            padding: 20px;
        }

        .box {
            margin-bottom: 20px;
            float: left;
            width: 220px;
        }

        .box img {
            max-width: 100%
        }
    </style>
</head>
<body>
这个确实是首页
<div id="masonry" class="container-fluid">
    @if ($goods)
        @foreach ($goods as $k=>$v)
            <div class="box">
                <a href="{{url('/home/index/detail?id='.$v->id)}}">
                    <img height="200" src="{{url($v->path)}}">
                </a>
                <div>
                    <h3>价格:{{$v->price}}</h3>
                    <h3>名称:{{$v->name}}</h3>
                    <h3>描述:{{strip_tags($v->content) ? strip_tags($v->content) : '暂无'}}</h3>
                    <h3>库存:<?php if ($v->total>0) {
                            echo '<span style="color:blue;">'.$v->total.'</span>';
                        } else {
                            echo '<span style="color:red;">'.$v->total.'</span>';
                        } ?></h3>
                </div>
            </div>
        @endforeach
    @endif

    {{----------------------------------------------------}}


    {{--<div class="box" v-for="good in goods">--}}

        {{--<a href="{{url('/home/index/detail?id=')}}">--}}
            {{--<img src="{{url('/uploads/371f0551149840041973b8b8199d28a6.jpg')}}">--}}
        {{--</a>--}}
        {{--<span></span>--}}
    {{--</div>--}}

    {{----------------------------------------------------}}

</div>
<script src="{{url('/js/vue.js')}}"></script>
<script src="http://libs.baidu.com/jquery/1.8.3/jquery.min.js"></script>
<script src="http://jq22.qiniudn.com/masonry-docs.min.js"></script>
<script>
    $(function () {
        var $container = $('#masonry');
        $container.imagesLoaded(function () {
            $container.masonry({
                itemSelector: '.box',
                gutter: 20,
                isAnimated: true,
            });
        });
    });
</script>
</body>
</html>