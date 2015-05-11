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
                <li ><a href="/PayGateway_v2/src/admin.php/Home/Index">支付网关</a></li>
                <?php foreach ($topMenu as $menu) { ?>
                    <?php if ($menu['permission'] == '1') { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $menu['name']; ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <?php foreach ($menu['child'] as $mlist) { ?>
                                    <?php if ($mlist['permission'] == '1') { ?>
                                        <li><a href="/PayGateway_v2/src/admin.php/Home/<?php echo $menu['code'] . '/' . $mlist['code']; ?>"><?php echo $mlist['name']; ?></a></li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                <?php } ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">你好，<?php echo $_SESSION['user']['name']; ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/PayGateway_v2/src/admin.php/Home/Admin/User/setpwd">修改密码</a></li>
                        <li><a href="/PayGateway_v2/src/admin.php/Home/Pub/Login/Logout">退出</a></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
<link href='http://<?php echo BASE_URL . STATIC_PUBLIC; ?>/css/bootstrap-datetimepicker.min.css'rel="stylesheet">
<script src='http://<?php echo BASE_URL . STATIC_PUBLIC; ?>/js/bootstrap-datetimepicker.js'></script>
<script src="http://<?php echo BASE_URL . STATIC_PUBLIC; ?>/js/bootstrap-datetimepicker.zh-CN.js"></script>
<div class="container theme-showcase">
    <div class="alert alert-danger hidden " role="alert" id='warn'>
        <strong>错误!</strong> Change a few things up and try submitting again.
    </div>
    <form action="" method="GET" role="form" class="well">
        <fieldset>
            <legend>统计</legend>            
            <p class="help-block"></p>
            <div class="row">
                <div class="col-lg-4">
                    <div class="input-group">
                        <span class="input-group-addon" >游戏</span>
                        <select name="game_id" id="game_id" class="form-control">
                            <option value="0">请选择</option>
                            <?php foreach ($select->game as $k => $v): ?>
                                <option value="<?php echo $k; ?>"><?php echo $k . ":" . $v; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <p class="help-block"></p>
            <div class="row">
                <div class="col-lg-4">
                    <div class="input-group">
                        <span class="input-group-addon">开始时间</span>
                        <input type="text" name="beginTime" id="beginTime" value="" class="form-control form_datetime">   
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input-group">
                        <span class="input-group-addon">结束时间</span>
                        <input type="text" name="endTime" id="endTime" value="" class="form-control form_datetime">   
                    </div>
                </div>
            </div>
            <p class="help-block"></p>
            <div class="form-actions">
                <button type="button" class="btn btn-primary" id="sub" data-loading-text="提交中...">搜索</button>
            </div>
        </fieldset>
    </form>
</div>
<div class="container" id="datalist">

</div>
<script>
    !function ($) {
        $('.form_datetime').datetimepicker({
            format: 'yyyy-mm-dd',
            language: 'zh-CN',
            weekStart: 0,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
            showMeridian: 0
        });
    }(window.jQuery);
    $(function () {
        $.ajax({
            url: "http://" + "<?php echo BASE_URL . "/PayGateway_v2/src/admin.php/Home/Order/Ordercount/getData/"; ?>",
            dataType: "html",
            cache: false,
            data: {},
            type: "get",
            success: function (data) {
                $("#datalist").html(data);
            }
        })
        $("#sub").click(function (event) {
            event.preventDefault();
            var btn = $(this).button('loading')
            var game_id = $("#game_id").val();
            var beginTime = $("#beginTime").val();
            var endTime = $("#endTime").val();
//            if (game_id == 0) {
//                $("#warn").html("<strong>错误!</strong> 请选择游戏");
//                $("#warn").removeClass("hidden");
//                btn.button('reset');
//            }
//            if (beginTime == '') {
//                $("#warn").html("<strong>错误!</strong> 请选择开始时间");
//                $("#warn").removeClass("hidden");
//                btn.button('reset');
//            }
//            if (endTime == '') {
//                $("#warn").html("<strong>错误!</strong> 请选择结束时间");
//                $("#warn").removeClass("hidden");
//                btn.button('reset');
//            }
            $.ajax({
                url: "http://" + "<?php echo BASE_URL . "/PayGateway_v2/src/admin.php/Home/Order/Ordercount/getData/"; ?>",
                dataType: "html",
                cache: false,
                data: {beginTime: beginTime, endTime: endTime, game_id: game_id},
                type: "GET",
                success: function (data) {
                    $("#datalist").html(data);
                    btn.button('reset');
                }
            })
        })
    });
</script>
</body>
</html>