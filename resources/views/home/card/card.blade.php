@include('/home/layout/top')
</head>
<h1>我的购物车</h1>
<table class="table table-bordered table-hover">
    @if($cards)
        <tr>
            <td>ID</td>
            <td>商品图片</td>
            <td>商品名称</td>
            <td>商品单价</td>
            <td>商品数量</td>
            <td>商品总价</td>
            <td>添加时间</td>
            <td>操作</td>
        </tr>
        @foreach($cards as $card)
            <tr>
                <td>{{$card->id}}</td>
                <td><img src="{{url($card->path)}}" height="100"></td>
                <td>{{$card->name}}</td>
                <td>{{$card->price}}</td>
                <td>{{$card->num}}</td>
                <td>{{$card->price * $card->num}}</td>
                <td>{{$card->created_at}}</td>
                <td><a href="{{url('home/card/delete?id='.$card->id)}}">删除</a></td>
            </tr>
        @endforeach
    @endif
</table>
<div style="float:right;margin-right:5%;">
    <button class="btn btn-success">结算</button>
</div>
<div class="meng">
    <span v-for="todo in todos">
        @{{ todo.text }}
    </span>
</div>
<script type="text/javascript">
    new Vue({
        el: '.meng',
        data: {
            todos: [
                { text: '<td>Learn Laravel</td>' },
                { text: '<td>Learn Vue.js</td>' },
                { text: '<td>At LaravelAcademy.org</td>' }
            ]
        }
    })
</script>
@include('/home/layout/bottom')