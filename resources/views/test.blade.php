<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel_test_vue</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
</head>
<body>

<div id="app">
   <page-card></page-card>
</div>
<script>
    var url = "{{url('/home/order/buyList')}}";
</script>
<script src="{{ mix('js/app.js') }}"></script>
 </body>
</html>




