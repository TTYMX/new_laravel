@extends('/admin/layout/layout')
@section('con')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">分类列表</h1>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                分类显示
            </div>
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                        <div class="row">
                            <form action="{{url('/admin/cate/index')}}">
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
                                                <option value="15"
                                                        @if(!empty($list['num']) && $list['num'] == 15)
                                                        selected
                                                        @endif

                                                >15
                                                </option>
                                                <option value="20"
                                                        @if(!empty($list['num']) && $list['num'] == 20)
                                                        selected
                                                        @endif
                                                >20
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
                                        <th class="" tabindex="0" aria-controls="dataTables-example"
                                            rowspan="1" colspan="1" style="width: 175px;" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">分类ID
                                        </th>
                                        <th class="" tabindex="0" aria-controls="dataTables-example" rowspan="1"
                                            colspan="1" style="width: 203px;"
                                            aria-label="Browser: activate to sort column ascending">名称
                                        </th>
                                        <th class="" tabindex="0" aria-controls="dataTables-example" rowspan="1"
                                            colspan="1" style="width: 184px;"
                                            aria-label="Platform(s): activate to sort column ascending">所属分类PID
                                        </th>
                                        <th class="" tabindex="0" aria-controls="dataTables-example" rowspan="1"
                                            colspan="1" style="width: 150px;"
                                            aria-label="Engine version: activate to sort column ascending">path路径
                                        </th>
                                        <th class="" tabindex="0" aria-controls="dataTables-example" rowspan="1"
                                            colspan="1" style="width: 108px;"
                                            aria-label="CSS grade: activate to sort column ascending">操作
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach( $cates as $k=>$v )
                                        <tr class="gradeA odd" role="row">
                                            <td class="">{{$v->id}}</td>
                                            <td>{{$v->name}}</td>
                                            <td class="center">{{$v->pid}}</td>
                                            <td class="center">{{$v->path}}</td>
                                            <td class="center">
                                                <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                        del="{{$v->id}}">删除
                                                </button>
                                                <a href="{{url('/admin/cate/edit?id='.$v->id)}}"
                                                   class="btn btn btn-success btn-sm">修改</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {!! $cates->appends($list)->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- Small modal -->


<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            ...
        </div>
    </div>
</div>

@section('js')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.delete-btn').click(function () {
            var id = $(this).attr('del');
            var btn = $(this);
            $.ajax({
                type: 'POST',
                url: '/admin/cate/delete',
                data: {'id': id},
                success: function (data) {
                    if (!data.errcode) {
                        btn.parents('tr').remove();
                    } else {
                        alert(data.msg);
                    }
                },
                dataType: 'json',

            });
        })
    </script>
@endsection