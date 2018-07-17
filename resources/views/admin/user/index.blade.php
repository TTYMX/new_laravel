@extends('admin.layout.layout')
@section('title','用户管理')
@section('con')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">用户列表</h1>
            </div>
        </div>
        <div class="row col-lg-12 panel panel-default panel-body">
            <div class="dataTable_wrapper">
                <div id="dataTables-example_wrapper"
                     class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                    <div class="row">
                        <form action="{{url('/admin/user/index')}}">
                            <div class="col-sm-6 dataTables_length" id="dataTables-example_length">
                                <label>
                                    显示
                                    <select name="num" aria-controls="dataTables-example"
                                            class="form-control input-sm">
                                        <option value="2"
                                                @if(!empty($list['num']) && $list['num'] == 2) {
                                                selected
                                                } @endif> 2
                                        </option>
                                        <option value="3"
                                                @if(!empty($list['num']) && $list['num'] == 3) {
                                                selected
                                                } @endif> 3
                                        </option>
                                        <option value="5"
                                                @if(!empty($list['num']) && $list['num'] == 5) {
                                                selected
                                                } @endif> 5
                                        </option>
                                        <option value="10"
                                                @if(!empty($list['num']) && $list['num'] == 10) {
                                                selected
                                                } @endif> 10
                                        </option>
                                    </select>条
                                </label>
                            </div>
                            <div id="col-sm-6 dataTables-example_filter" class="dataTables_filter">
                                <label>搜索:
                                    <input name="keywords" value="{{ $list['keywords'] or '' }}"
                                           class="form-control input-sm"
                                           aria-controls="dataTables-example"
                                           type="search"/>
                                </label>
                                <button type="submit" class="btn btn-primary">查询</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer"
                               id="dataTables-example" role="grid"
                               aria-describedby="dataTables-example_info">
                            <thead>
                            <tr>
                                <th>用户Id</th>
                                <th>用户头像</th>
                                <th>用户名</th>
                                <th>用户邮箱</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $k=>$v)
                                <tr class="gradeA odd" role="row">
                                    <td class="sorting_1">{{$v->id}}</td>
                                    <td><img src="{{asset($v->pic)}}" width="50px" height="50px"></td>
                                    <td>{{$v->username}}</td>
                                    <td class="center">{{$v->email}}</td>
                                    <td class="center">
                                        <button type="btn" class="btn btn-danger btn-sm delete-btn">删除
                                        </button>
                                        <a href="{{url('/admin/user/edit?id='.$v->id)}}"
                                           class="btn btn-success btn-sm">修改</a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    {!! $users->appends($list)->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //绑定单击事件
        $('.delete-btn').click(function () {
            var id = $(this).parents('tr').find('.sorting_1').html();
            var btn = $(this);
            var r = confirm('确定要删除么?');
            //发送ajax请求
            if (r) {
                $.post('/admin/user/delete', {id: id}, function (res) {
                    if (res == 1) {
                        btn.parents('tr').remove();
                    } else {
                        alert('删除失败');
                    }
                });
            }
        })
    </script>
@endsection