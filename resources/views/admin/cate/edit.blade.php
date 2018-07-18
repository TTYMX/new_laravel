@extends('/admin/layout/layout')
@section('con')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">分类修改</h1>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    修改表单
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
                            <form role="form" action="{{url('/admin/cate/update')}}" method="post"
                                  enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>分类名:</label>
                                    <input name="name" type="text" value="{{$cates->name}}" class="form-control">
                                </div>
                                <input name="id" type="hidden" value="{{$cates->id}}">
                                {{csrf_field()}}
                                <button type="submit" class="btn btn-danger">提交修改</button>
                                <button type="reset" class="btn btn-warning">重置表单</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection