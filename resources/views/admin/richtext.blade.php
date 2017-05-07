<!DOCTYPE HTML>
<html lang="en-US">

    <head>
        <meta charset="UTF-8">
        <title>富文本编辑</title>
        <style>
            #submit-btn {
                float: right;
                margin-top: 20px;

                border-width: 0;
                border-radius: 5px;
                background-color: #20A0FF;
                color: white;
                padding: 10px 20px;
            }
        </style>
    </head>

    <body>
        <!-- 加载编辑器的容器 -->
        <div style="width: 960px;margin: 0 auto; ">
            <script id="container" name="content" type="text/plain" style="min-height: 400px;">
            </script>
            <button id="submit-btn">提交</button>
        </div>
        <!-- 配置文件 -->
        <script type="text/javascript" src="/plugins/ueditor/ueditor.config.js"></script>
        <!-- 编辑器源码文件 -->
        <script type="text/javascript" src="/plugins/ueditor/ueditor.all.js"></script>
        <script src="/web/frame/jquery/jquery.min.js"></script>
        <!-- 实例化编辑器 -->
        <script type="text/javascript">
            var ue = UE.getEditor('container');
            ue.ready(function () {
                ue.setContent('{!! $richtext ? $richtext->content : '' !!}');
                $("#submit-btn").click(function () {
                    var content = ue.getContent();
                    $.ajax({
                        url: '/admin/richtext',
                        method: 'post',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: "{{ $richtext ? $richtext->id : 0 }}",
                            module: "{{ $module }}",
                            htmlable_id: "{{ $id }}",
                            content: content
                        },
                        success: function (data) {
                            if (data.success) {
                                window.close();
                            } else {
                                alert(data.infor);
                            }
                        }
                    })
                });
            });
        </script>
    </body>

</html>