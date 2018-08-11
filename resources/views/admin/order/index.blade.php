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

                            <form action="{{url('/admin/orders/index')}}">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="dataTables_length" id="dataTables-example_length">
                                            <label>显示
                                                <select name="num" aria-controls="dataTables-example" value="10"
                                                        class="form-control input-sm">
                                                    <option value="10"
                                                            @if(!empty($list['num']) && $list['num']==10)
                                                            selected
                                                            @endif
                                                    >10
                                                    </option>
                                                    <option value="3"
                                                            @if(!empty($list['num']) && $list['num']==3)
                                                            selected
                                                            @endif>3
                                                    </option>
                                                    <option value="5"
                                                            @if(!empty($list['num']) && $list['num']==5)
                                                            selected
                                                            @endif
                                                    >5
                                                    </option>
                                                    <option value="8"
                                                            @if(!empty($list['num']) && $list['num']==8)
                                                            selected
                                                            @endif
                                                    >8
                                                    </option>

                                                </select>条</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div id="dataTables-example_filter" class="dataTables_filter">
                                            <label>搜索订单号:
                                                <input name="keywords" value="{{$list['keywords'] or ''}}"
                                                       class="form-control input-sm" placeholder=""
                                                       aria-controls="dataTables-example" type="search">
                                                <button class="btn btn-primary btn-sm">查找</button>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>


                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped table-bordered table-hover dataTable no-footer"
                                           id="dataTables-example" role="grid"
                                           aria-describedby="dataTables-example_info">
                                        <thead>
                                            <th style="width:6%">订单ID</th>
                                            <th style="width:8%">用户名称</th>
                                            <th style="width:5%">金额</th>
                                            <th style="width:15%">订单号</th>
                                            <th style="width:12%">状态</th>
                                            <th style="width:15%">购买时间</th>
                                            <th style="width:15%">操作</th>
                                        </thead>

                                        @foreach($orders as $k=>$v)
                                            <tr>
                                                <td>{{$v->id}}</td>
                                                <td>{{$v->username}}</td>
                                                <td>{{$v->price}}</td>
                                                <td>{{$v->order_num}}</td>
                                                @if ($v->tatus == 1)
                                                    <td>未付款</td>
                                                @else
                                                    <td>已付款</td>
                                                @endif
                                                <td>{{$v->created_at}}</td>
                                                @if ($v->status == 1)
                                                    <td>
                                                        <button class="btn btn-sm btn-success send" edit="{{$v->id}}">
                                                            发货
                                                        </button>
                                                    </td>
                                                @else
                                                    <td>
                                                        <button class="btn btn-sm btn-success send" edit="{{$v->id}}">
                                                            已发货
                                                        </button>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            <div>
                                {!!$orders->appends($list)->render()!!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(function () {
            $('.send').click(function () {
                var btn = $(this);
                var id = $(this).attr('edit');
                var url = "<?php echo url('/admin/orders/edit'); ?>";
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {id:id},
                    dataType: "json",
                    success: function(data){
                        if (!data.errcode) {
                            alert('发送成功');
                            btn.html('已发货');
                        } else {
                            //删除失败
                            alert('发送失败');
                        }
                    }
                });
            })
        })
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
        // $('.delete-btn').click(function () {
        //     var id = $(this).attr('del');
        //     var btn = $(this);
        //     $.post('/admin/goods/delete', {id: id}, function (data) {
        //         if (!data.errcode) {
        //             btn.parents('tr').remove();
        //         } else {
        //             //删除失败
        //             alert('删除失败');
        //         }
        //     });
        // })
        // //上架下架操作
        // $('.update-btn').click(function () {
        //     var btn = $(this);
        //     var id = $(this).attr('stid');
        //     var status = $(this).attr('status');
        //     status == 2 ? $(this).attr('status',1) : $(this).attr('status',2);
        //     $.post('/admin/goods/updateStatus', {'id': id,'status':status}, function (data) {
        //         if (!data.errcode) {
        //             btn.text(data.msg);
        //         }
        //     }, 'json');
        // })

    </script>

@endsection