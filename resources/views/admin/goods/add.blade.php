@extends('/admin/layout/layout')
	@section('con')
     <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">商品添加</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
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

            	                                    <form role="form" action="{{url('/admin/goods/insert')}}" method="post" enctype="multipart/form-data">
            	                                        
                                                        <div class="form-group">
                                                            <label>所属类别</label>
                                                            <select class="form-control" name="cate_id">
                                                                <option value="0">顶级分类</option>
                                                                @foreach ( $cates as $k => $v )
                                                                    <option value="{{$v->id}}">{{ $v->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>商品名:</label>
                                                            <input name="name" type="text" value="{{old('name')}}" class="form-control">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>图片:</label>
                                                            <input type="file" multiple name="pic[]">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>商品价格:</label>
                                                            <input name="price" type="text" value="{{old('price')}}" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>商品库存:</label>
                                                            <input name="total" type="text" value="{{old('total')}}" class="form-control">
                                                        </div>

                                                        <script type="text/javascript" charset="utf-8" src="/baidubianjiqi/ueditor.config.js"></script>
                                                           <script type="text/javascript" charset="utf-8" src="/baidubianjiqi/ueditor.all.min.js"> </script>
                                                           <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
                                                           <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
                                                           <script type="text/javascript" charset="utf-8" src="/baidubianjiqi/lang/zh-cn/zh-cn.js"></script>

                                                        <div class="form-group">
            	                                            <label>商品详情:</label>
            	                                            <script id="editor" name="content" type="text/plain" style="width:500px;height:200px;">
                                                          
                                                            </script>
            	                                        </div>
            	                                        
            	                                        {{csrf_field()}}
            	                                    
            	                                        <button type="submit" class="btn btn-danger">提交</button>
            	                                        <button type="reset" class="btn btn-warning">重置</button>
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
    @section('js')
    <script type="text/javascript">
        //实例化编辑器
           //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
           var ue = UE.getEditor('editor',{
            toolbars: [
                [
                    'anchor', //锚点
                    'undo', //撤销
                    'redo', //重做
                    'bold', //加粗
                    'indent', //首行缩进
                    'snapscreen', //截图
                    'italic', //斜体
                    'underline', //下划线
                    'strikethrough', //删除线
                    'subscript', //下标
                    'fontborder', //字符边框
                    'superscript', //上标
                    'formatmatch', //格式刷
                    'source', //源代码
                    'blockquote', //引用
                    'pasteplain', //纯文本粘贴模式
                    'selectall', //全选
                    'print', //打印
                    'preview', //预览
                    'horizontal', //分隔线
                    'removeformat', //清除格式
                    'time', //时间
                    'date', //日期
                    'unlink', //取消链接
                    'insertrow', //前插入行
                    'insertcol', //前插入列
                    'mergeright', //右合并单元格
                    'mergedown', //下合并单元格
                    'deleterow', //删除行
                    'deletecol', //删除列
                    'splittorows', //拆分成行
                    'splittocols', //拆分成列
                    'splittocells', //完全拆分单元格
                    'deletecaption', //删除表格标题
                    'inserttitle', //插入标题
                    'mergecells', //合并多个单元格
                    'deletetable', //删除表格
                    'cleardoc', //清空文档
                    'insertparagraphbeforetable', //"表格前插入行"
                    'insertcode', //代码语言
                    'fontfamily', //字体
                    'fontsize', //字号
                    'paragraph', //段落格式
                    'simpleupload', //单图上传
                    'insertimage', //多图上传
                    'edittable', //表格属性
                    'edittd', //单元格属性
                    'link', //超链接
                    'emotion', //表情
                    'spechars', //特殊字符
                    'searchreplace', //查询替换
                    'map', //Baidu地图
                    'gmap', //Google地图
                    'insertvideo', //视频
                    'help', //帮助
                    'justifyleft', //居左对齐
                    'justifyright', //居右对齐
                    'justifycenter', //居中对齐
                    'justifyjustify', //两端对齐
                    'forecolor', //字体颜色
                    'backcolor', //背景色
                    'insertorderedlist', //有序列表
                    'insertunorderedlist', //无序列表
                    'fullscreen', //全屏
                    'directionalityltr', //从左向右输入
                    'directionalityrtl', //从右向左输入
                    'rowspacingtop', //段前距
                    'rowspacingbottom', //段后距
                    'pagebreak', //分页
                    'insertframe', //插入Iframe
                    'imagenone', //默认
                    'imageleft', //左浮动
                    'imageright', //右浮动
                    'attachment', //附件
                    'imagecenter', //居中
                    'wordimage', //图片转存
                    'lineheight', //行间距
                    'edittip ', //编辑提示
                    'customstyle', //自定义标题
                    'autotypeset', //自动排版
                    'webapp', //百度应用
                    'touppercase', //字母大写
                    'tolowercase', //字母小写
                    'background', //背景
                    'template', //模板
                    'scrawl', //涂鸦
                    'music', //音乐
                    'inserttable', //插入表格
                    'drafts', // 从草稿箱加载
                    'charts', // 图表
                ]
            ]

           });

    </script>

    @endsection