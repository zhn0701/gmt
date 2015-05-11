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
<!-- Fixed navbar -->
<link rel="stylesheet" href="http://<?php echo C('STATIC_PUBLIC'); ?>/css/index.css">
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li ><a href="/gmt/src/admin.php/Home/Index">支付网关</a></li>
                <?php foreach ($topMenu as $menu) { ?>
                    <?php if ($menu['permission'] == '1') { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $menu['name']; ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <?php foreach ($menu['child'] as $mlist) { ?>
                                    <?php if ($mlist['permission'] == '1') { ?>
                                        <li><a href="/gmt/src/admin.php/Home/<?php echo $menu['code'] . '/' . $mlist['code']; ?>"><?php echo $mlist['name']; ?></a></li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                <?php } ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">你好，<?php echo $_SESSION['user']['name']; ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/gmt/src/admin.php/Home/Admin/User/setpwd">修改密码</a></li>
                        <li><a href="/gmt/src/admin.php/Home/Pub/Login/Logout">退出</a></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
<div class="container">
    <div class="alert alert-danger hidden " role="alert" id='warn'>
        <strong>错误!</strong> Change a few things up and try submitting again.
    </div>
    <div class="alert alert-success hidden" role="alert" id='success'>
        <strong>成功!</strong> You successfully read this important alert message.
    </div>
    <form class="form-signin">
        <h2 class="form-signin-heading" id='t1'>修改密码</h2>
        <label for="inputOldpwd" class="sr-only">旧密码</label>
        <input type="password" id="inputOldpwd" class="form-control" placeholder="旧密码" required autofocus>
        <label class="list-inline"></label>
        <label for="inputNewpwd" class="sr-only">新密码</label>
        <input type="password" id="inputNewpwd" class="form-control" placeholder="新密码" required>
        <label for="inputRepwd" class="sr-only">新密码</label>
        <input type="password" id="inputRepwd" class="form-control" placeholder="再次输入" required>
        <!--
        <div class="checkbox">
          <label>
            <input type="checkbox"  value="remember-me"> Remember me
          </label>
        </div>
        -->
        <button class="btn btn-lg btn-primary btn-block" type="submit" id='sub' autocomplete="off" data-loading-text="Loading...">提交</button>
    </form>
</div> <!-- /container -->  
<script>
    $('#sub').on('click', function (event) {
        event.preventDefault();
        var btn = $(this).button('loading')
        var oldpwd = $("#inputOldpwd").val();
        var newpwd = $("#inputNewpwd").val();
        var repwd = $("#inputRepwd").val();
        // business logic...
        if (oldpwd == '') {
            $("#warn").html("<strong>错误!</strong> 旧密码必须填写");
            $("#warn").removeClass("hidden");
            btn.button('reset');
            return;
        }
        if(newpwd == ''){
            $("#warn").html("<strong>错误!</strong> 新密码必须填写");
            $("#warn").removeClass("hidden");
            btn.button('reset');
            return;
        }
        if(newpwd != repwd){
            $("#warn").html("<strong>错误!</strong> 2次密码填写不正确");
            $("#warn").removeClass("hidden");
            btn.button('reset');
            return;
        }
        if(newpwd == oldpwd){
            $("#warn").html("<strong>错误!</strong> 新旧密码不能一样");
            $("#warn").removeClass("hidden");
            btn.button('reset');
            return;
        }
        var url = "http://" + "<?php echo BASE_URL . "/gmt/src/admin.php/Home/Admin/User" . "/setpwd"; ?>";
        $.ajax({
            type: 'POST',
            data: {oldpwd: oldpwd, newpwd: newpwd,repwd:repwd},
            url: url,
            cache: false,
            dataType: "json",
            success: function (data) {
                if (data) {
                    if (data.code == 1) {
                        $("#success").html("<strong>成功!</strong> " + data.msg);
                        $("#success").removeClass("hidden");
                        $("#warn").addClass("hidden");
                        btn.button('reset')
                    }
                    else {
                        $("#warn").html("<strong>错误!</strong> " + data.msg);
                        $("#warn").removeClass("hidden");
                        $("#success").addClass("hidden");
                        btn.button('reset')
                    }
                }
            }
        });
    });
</script>
</body>
</html>