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
                                                        <a href="/admin/orders/edit?id={{$v->id}}"
                                                           class="btn btn-sm btn-success">
                                                            发货
                                                        </a>
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
