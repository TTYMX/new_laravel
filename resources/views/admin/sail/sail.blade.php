@extends('admin.layout.layout')
@section('title','订单管理')
@section('con')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">订单默认</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 ">
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <div id="dataTables-example_wrapper"
                             class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div class="" style="float:right;">
                                <input type="date" id="start">
                                <input type="date" id="end">
                                <button class="btn btn-primary btn-sm excel">导出excel</button>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    @foreach($sail as $k=>$v)
                                        <p>时间:{{$k}}</p>
                                        <table class="table table-bordered table-hover no-footer">
                                            <thead class="striped">
                                            <th>ID</th>
                                            <th>名称</th>
                                            <th>数量</th>
                                            </thead>
                                            <tbody>
                                                @foreach($v as $kk=>$vv)
                                                    <tr>
                                                        <td>{{$vv['id']}}</td>
                                                        <td>{{$vv['name']}}</td>
                                                        <td>{{$vv['num']}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                {!!$res->appends($list)->render()!!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var url = "{{url('admin/sail/excel')}}";
        var JsonData = {};
        $('.excel').click(function(){
            console.log();
            console.log();
            var start = $('#start').val();
            var end = $('#end').val();
            if (start || end) {
                url = url+'?start='+start+'&end='+end;
            }
            console.log(url);
            location.href=url;
        });
    </script>
@endsection
