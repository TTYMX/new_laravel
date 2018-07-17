@extends('admin.layout.layout')
@section('title','用户管理')
@section('con')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">用户添加</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-8 col-lg-offset-2">
                                <form role="form" action="{{url('/admin/user/insert')}}" method="post"
                                      enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>用户名</label>
                                        <input name="username" value="{{old('username')}}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>密码</label>
                                        <input name="password" value="{{old('password')}}" type="password"
                                               class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>邮箱</label>
                                        <input name="email" value="{{old('email')}}" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>手机号</label>
                                        <input name="phone" value="{{old('phone')}}" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>开启后台权限</label>
                                        <input type="checkbox" name="auth" value="1">
                                    </div>
                                    <div class="form-group">
                                        <label>男</label>
                                        <input type="radio" name="sex" value="1">
                                        <label>女</label>
                                        <input type="radio" name="sex" value="0" checked>
                                    </div>
                                    <div class="form-group">
                                        <label>头像</label>
                                        <input type="file" name="pic">
                                    </div>
                                    {{csrf_field()}}
                                    <button type="submit" class="btn btn-primary">添加</button>
                                    <button type="reset" class="btn btn-danger">重置</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection