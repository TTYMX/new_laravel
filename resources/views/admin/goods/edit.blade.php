 @extends('/admin/layout/layout')
	@section('con')
     <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">用户修改</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
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

            	                                    <form role="form" action="{{url('/admin/goods/update')}}" method="post" enctype="multipart/form-data">
            	                                        <div class="form-group">
            	                                            <label>商品名:</label>
            	                                            <input name="name" type="text" value="{{$goods->name}}" class="form-control">
            	                                        </div>

                                                        <div class="form-group">
                                                            <label>所属类别</label>
                                                            <select class="form-control" name="cate_id" >
                                                                <option value="0">顶级分类</option>
                                                                @foreach ( $cates as $k => $v )
                                                                    <option value="{{$v->id}}" 
                                                                    @if($goods->cate_id == $v->id) 
                                                                        selected
                                                                    @endif
                                                                    > {{ $v->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

            	                                        <div class="form-group">
            	                                            <label>商品价格:</label>
            	                                            <input name="price" type="tex" value="{{$goods->price}}" class="form-control">
            	                                        </div>
            	                                        <div class="form-group">
            	                                            <label>库存:</label>
            	                                            <input name="total" type="text" value="{{$goods->total}}" class="form-control">
            	                                        </div>
            	                                        <div class="form-group">
            	                                            <label>状态:</label>
            	                                            <input name="status" type="text" value="{{$goods->status}}" class="form-control">
            	                                        </div>
            	                                        <input name="id" type="hidden" value="{{$goods->id}}">
            	                                        <div class="form-group">
            	                                            <label>商品图片:</label>
            	                                            <input type="file" name="pic">
            	                                            <img src="{{$goods->pic}}" width="100px">
            	                                        </div>
            	                                        {{csrf_field()}}
            	                                    
            	                                        <button type="submit" class="btn btn-danger">提交修改</button>
            	                                        <button type="reset" class="btn btn-warning">重置表单</button>
                                                        
            	                                    </form>
            	                                </div>
            	                               
            	                            </div>
            	                            <!-- /.row (nested) -->
            	                        </div>
            	                        <!-- /.panel-body -->
            	                    </div>

            </div>
   
        </div>
    @endsection