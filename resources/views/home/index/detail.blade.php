@include('/home/layout/top')
<title>商品详情页面</title>
</head>
<body>
<div id="app">
    <page-detail></page-detail>
</div>
<script>
    var url = "{{url('/home/card/card')}}";
    var buy_url = "{{url('/home/order/buy')}}";
    var card_url = "{{url('/home/card/card')}}";
</script>
<script src="{{ mix('js/app.js') }}"></script>
@include('/home/layout/bottom')