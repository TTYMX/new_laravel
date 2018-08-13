include_once('/home/layout/top')
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
<div id="app">
    <page-index></page-index>
</div>
<script>
    var goods = "{{$goods}}";
    var url = "{{url('/home/index/index')}}";
    var detail_url = "{{url('/home/index/detail')}}";
</script>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>