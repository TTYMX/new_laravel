@include('/home/layout/top')
<h1>评论订单列表</h1>
<div>
    <p>订单号：{{$order['order_num']}}</p>
    <p>名　称：{{$good['name']}}</p>
    <p>金　额：{{$order['price']}}</p>
    <p>时　间：{{$order['created_at']}}</p>
    <p><img height="100px" src="{{$pic['path']}}" alt=""></p>
</div>
<h1>评论</h1>
    <div>
        <textarea cols="50" rows="8" class="text"></textarea>
    </div>
    <div>
        <button class="btn" type="button">上传图片</button>
    </div>
<script>
    $('.btn').click(function(){
        alert('btn');
    });
</script>
@include('/home/layout/bottom')