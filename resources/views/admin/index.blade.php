<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/admin/reset.css"> 
        <style>
            html {
                font-family: "Helvetica Neue",Helvetica,"PingFang SC","Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
            }
        </style>
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
        
    </head>
    <body>
        <div id="app"></div>
        <script src=".{{ elixir('js/admin/app.js') }}"></script>
    </body>
</html>