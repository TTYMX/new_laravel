@include('/home/layout/top')
<h1>评论订单列表</h1>
<div>
    <p>订单号：{{$order['order_num']}}</p>
    <p>名　称：{{$good['name']}}</p>
    <p>金　额：{{$order['price']}}</p>
    <p>时　间：{{$order['created_at']}}{{$order['comment_pic']}}</p>
    <p><img height="100px" src="{{$pic['path']}}" alt=""></p>
</div>
<a href="{{url('home/index/detail?id='.$order['id'])}}">返回</a>
<h1>评论</h1>
<div>
    <textarea cols="50" rows="8" class="text">{{$order['comment']}}</textarea>
</div>
<div>
    <button class="btn upload" type="button">
        上传图片
    </button>
    <input type="file" id="file" name="file" style="display:none;">
    <button style="margin-left:200px;" class="btn submit" type="button">提交评论</button>
</div>
<div>
    <img height="200px" src="{{$order['comment_pic']}}" alt="" id="img" style="<?php echo $order['comment_pic'] ? '' : 'display:none'; ?>">
</div>
<script>
    $('input[type="file"]').on('change', function () {
        var formData = new FormData();
        formData.append('file', $(this)[0].files[0]);
        formData.append('id', {{$order['id']}});
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{url('/home/upload/upload')}}",
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {
                if (!data.errcode) {
                    $("#img").attr('src',data.msg).css('display','block');
                } else {
                    alert('上传失败');
                }
            }
        });
    });
    $('.upload').click(function () {
        $('#file').trigger('click');
    });
    $('.submit').click(function () {
        var text = $('.text').val();
        var id = "{{$order['id']}}";
        var JsonData = {text: text,'is_comment':1,'id':id};
        $.ajax({
            type: "GET",
            url: "{{url('/home/order/comment')}}",
            data: JsonData,
            dataType: "json",
            success: function (data) {
                if (!data.errcode) {
                    alert('评价成功');
                } else {
                    //删除失败
                    alert('评价失败');
                }
            }
        });
    })
</script>
@include('/home/layout/bottom')