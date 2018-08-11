@include('/home/layout/top')
<div id="app">
    <page-card></page-card>
</div>
<script>
    var url = "{{url('/home/card/list')}}";
    var del_url = "{{url('/home/card/delete')}}";
</script>
<script src="{{ mix('js/app.js') }}"></script>
@include('/home/layout/bottom')
