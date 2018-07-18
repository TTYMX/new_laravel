@extends('/admin/layout/layout')
@section('con')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">分类添加</h1>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    添加表单
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-5 col-lg-offset-3">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form role="form" action="{{url('/admin/cate/insert')}}" method="post"
                                  enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>所属分类</label>
                                    <select class="form-control" name="pid">
                                        <option value="0">顶级分类</option>
                                        @foreach ( $cates as $k => $v )
                                            <option value="{{$v->id}}">{{ $v->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>分类名:</label>
                                    <input name="name" type="text" value="" class="form-control">
                                </div>
                                {{csrf_field()}}
                                <button type="submit" class="btn btn-danger">提交</button>
                                <button type="reset" class="btn btn-warning">重置</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection