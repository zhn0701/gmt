<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
        <meta name="description" content="">
        <meta name="author" content="">
        <!--<link rel="icon" href="../../favicon.ico"> -->

        <title><?php echo $title; ?></title>

        <!-- 新 Bootstrap 核心 CSS 文件 -->
        <link rel="stylesheet" href="http://<?php echo BASE_URL . STATIC_PUBLIC; ?>/dist/css/bootstrap.min.css">

        <!-- 可选的Bootstrap主题文件（一般不用引入） -->
        <!--<link rel="stylesheet" href="./Public/dist/css/bootstrap-theme.min.css">-->

        <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
        <script src="http://<?php echo BASE_URL . STATIC_PUBLIC; ?>/js/jquerymin.js"></script>
        <script src="http://<?php echo BASE_URL . STATIC_PUBLIC; ?>/js/common.js"></script>
        <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
        <script src="http://<?php echo BASE_URL . STATIC_PUBLIC; ?>/dist/js/bootstrap.min.js"></script>


        <!-- Custom styles for this template -->
        <!-- <link href="starter-template.css" rel="stylesheet">-->

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
<body>
    <link rel="stylesheet" href="http://<?php echo C('STATIC_PUBLIC'); ?>/css/login.css">
    <div class="container">
        <div class="alert alert-danger hidden " role="alert" id='warn'>
            <strong>错误!</strong> Change a few things up and try submitting again.
        </div>
        <div class="alert alert-success hidden" role="alert" id='success'>
            <strong>成功!</strong> You successfully read this important alert message.
        </div>
        <form class="form-signin">
            <h2 class="form-signin-heading" id='t1'>RGZ GM Tools</h2>
            <label for="inputAccount" class="sr-only">Account</label>
            <input type="text" id="inputAccount" class="form-control" placeholder="Account" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
            <!--
            <div class="checkbox">
              <label>
                <input type="checkbox"  value="remember-me"> Remember me
              </label>
            </div>
            -->
            <button class="btn btn-lg btn-primary btn-block" type="submit" id='sub' autocomplete="off" data-loading-text="Loading...">登录</button>
        </form>

    </div> <!-- /container -->  
    <script>
        $('#sub').on('click', function (event) {
            event.preventDefault();
            var btn = $(this).button('loading')
            var account = $("#inputAccount").val();
            var password = $("#inputPassword").val();
            // business logic...
            //btn.button('reset')
            var url = "http://" + "<?php echo BASE_URL . "/gmt/src/admin.php/Home/Pub/Login" . "/login"; ?>";
            $.ajax({
                type: 'POST',
                data: {account: account, password: password},
                url: url,
                cache: false,
                dataType: "json",
                success: function (data) {
                    if (data) {
                        if (data.code == 1) {
                            $("#success").html("<strong>登录成功!</strong> " + data.msg);
                            $("#success").removeClass("hidden");
                            window.location.href = "http://" + "<?php echo BASE_URL . "/gmt/src/admin.php/Home" . "/Index"; ?>";
                        }
                        else {
                            $("#warn").html("<strong>错误!</strong> " + data.msg);
                            $("#warn").removeClass("hidden");
                            btn.button('reset')
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>