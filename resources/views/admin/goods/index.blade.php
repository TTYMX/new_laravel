@extends('/admin/layout/layout')
@section('con')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">商品列表</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="panel panel-default">
            <div class="panel-heading">
                商品显示
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                        <div class="row">
                            <form action="{{url('/admin/goods/index')}}">
                                <div class="col-sm-6">
                                    <div class="dataTables_length" id="dataTables-example_length">
                                        <label>显示
                                            <select name="num" aria-controls="dataTables-example"
                                                    class="form-control input-sm">
                                                <option value="5"
                                                        @if(!empty($list['num']) && $list['num'] == 5)
                                                        selected
                                                        @endif
                                                >5
                                                </option>
                                                <option value="10"
                                                        @if(!empty($list['num']) && $list['num'] == 10)
                                                        selected
                                                        @endif
                                                >10
                                                </option>
                                                <option value="20"
                                                        @if(!empty($list['num']) && $list['num'] == 20)
                                                        selected
                                                        @endif

                                                >20
                                                </option>
                                                <option value="50"
                                                        @if(!empty($list['num']) && $list['num'] == 50)
                                                        selected
                                                        @endif
                                                >50
                                                </option>
                                            </select> 条
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div id="dataTables-example_filter" class="dataTables_filter">
                                        <label>查询:
                                            <input name="keywords" value="{{ $list['keywords'] or '' }}"
                                                   class="form-control input-sm" placeholder=""
                                                   aria-controls="dataTables-example" type="search">
                                        </label>
                                        <button type="" class="btn btn-primary">搜索</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped table-bordered table-hover dataTable no-footer"
                                       id="dataTables-example" role="grid" aria-describedby="dataTables-example_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="dataTables-example"
                                            rowspan="1" colspan="1" style="width: 175px;" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">商品ID
                                        </th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="dataTables-example"
                                            rowspan="1" colspan="1" style="width: 175px;" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">商品名
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1"
                                            colspan="1" style="width: 203px;"
                                            aria-label="Browser: activate to sort column ascending">商品图片
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1"
                                            colspan="1" style="width: 203px;"
                                            aria-label="Browser: activate to sort column ascending">所属类
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1"
                                            colspan="1" style="width: 184px;"
                                            aria-label="Platform(s): activate to sort column ascending">价格
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1"
                                            colspan="1" style="width: 150px;"
                                            aria-label="Engine version: activate to sort column ascending">库存
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1"
                                            colspan="1" style="width: 150px;"
                                            aria-label="Engine version: activate to sort column ascending">状态
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1"
                                            colspan="1" style="width: 108px;"
                                            aria-label="CSS grade: activate to sort column ascending">操作
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($goods as $k=>$v)
                                        <tr class="gradeA odd" role="row">
                                            <td class="sorting_1">{{$v->id}}</td>
                                            <td class="sorting_1">{{$v->name}}</td>
                                            <td><img src="{{$v->pic}}" width="50px" height="70px"></td>
                                            <td>{{$v->names}}</td>
                                            <td>{{$v->price}}</td>
                                            <td class="center">{{$v->total}}</td>
                                            <td class="center">
                                                <button type="button"
                                                        class="btn btn-primary btn-xs update-btn">{{$v->status}}</button>
                                            </td>
                                            <td class="center" width="150px">
                                                <button type="button" class="btn btn-danger btn-sm delete-btn">删除
                                                </button>
                                                <a href="/admin/goods/edit?id={{$v->id}}"
                                                   class="btn btn btn-success btn-sm">修改</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {!! $goods->appends($list)->render() !!}
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
        // alert($);
        // 绑定单机事件
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.delete-btn').click(function () {
            var id = $(this).parents('tr').find('.sorting_1').html();
            // alert(id);
            // 发送ajax
            var btn = $(this);
            $.post('/admin/goods/delete', {id: id}, function (data) {
                // alert(data);
                // console.log(data);
                if (data == 1) {
                    alert('删除成功');
                    btn.parents('tr').remove();
                } else {
                    //删除失败
                    alert('删除失败');
                }
            });
        })
        //上架下架操作
        $('.update-btn').click(function () {
            // alert(111);
            var btn = $(this);
            var id = $(this).parents('tr').find('.sorting_1').html();
            // alert(id);
            // 发送ajax
            $.post('/admin/goods/updatestatus', {id: id}, function (data) {

                btn.text(data);
                // alert(data);
            });
        })

    </script>

@endsection