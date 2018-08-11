@include('/home/layout/top')
<h1>我的订单列表</h1>
<div id="app">
    <page-order></page-order>
</div>
<script>
    var url = "{{url('/home/order/buyList')}}";
    var ping = "{{url('/home/order/ping')}}";
</script>
<script src="{{ mix('js/app.js') }}"></script>
@include('/home/layout/bottom')