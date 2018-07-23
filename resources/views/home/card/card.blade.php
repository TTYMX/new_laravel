@include('/home/layout/top')
<h1>我的购物车</h1>
<table class="table table-bordered table-hover title">
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
        {{--@foreach($cards as $card)--}}
            {{--<tr>--}}
                {{--<td>{{$card->id}}</td>--}}
                {{--<td><img src="{{url($card->path)}}" height="100"></td>--}}
                {{--<td>{{$card->name}}</td>--}}
                {{--<td>{{$card->price}}</td>--}}
                {{--<td>{{$card->num}}</td>--}}
                {{--<td>{{$card->price * $card->num}}</td>--}}
                {{--<td>{{$card->created_at}}</td>--}}
                {{--<td><a href="{{url('home/card/delete?id='.$card->id)}}">删除</a></td>--}}
            {{--</tr>--}}
        {{--@endforeach--}}
        <tr v-for="todo in todos">
            @{{ todo.text }}
        </tr>
    @endif
</table>
<div style="float:right;margin-right:5%;">
    <button class="btn btn-success">结算</button>
</div>
<div class="content">
    <div class="title">
        <ul>
            <li v-for="todo in todos">
                @{{ todo.text }}
            </li>
        </ul>
    </div>
</div>
<script type="text/javascript">
    new Vue({
        el: '.title',
        data: {
            todos: [
                { text: 'Learn Laravel' },
                { text: 'Learn Vue.js' },
                { text: 'At LaravelAcademy.org' }
            ]
        }
    })
</script>
@include('/home/layout/bottom')