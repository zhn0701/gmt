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
                <li ><a href="/gmt/src/admin.php/Home/Index">RGZ</a></li>
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
<div class="container theme-showcase">
    <div class="alert alert-danger hidden " role="alert" id='warn'>
        <strong>错误!</strong> Change a few things up and try submitting again.
    </div>
    <form action="" method="GET" role="form" class="well">
        <fieldset>
            <legend>发送邮件/道具</legend>            
            <p class="help-block"></p>
            <div class="row">
                <div class="col-lg-4">
                    <div class="input-group">
                        <span class="input-group-addon" >游戏大区</span>
                        <select name="serverId" id="serverId" class="form-control">
                            <option value="0">请选择</option>
                            <?php foreach ($select->server as $k => $v): ?>
                                <option value="<?php echo $k; ?>"><?php echo $k . ":" . $v['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <p class="help-block"></p>
            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group">
                        <span class="input-group-addon">标题</span>
                        <input type="text" name="title" id="title" value="" class="form-control " placeholder="">
                    </div>
                </div>
            </div>
            <p class="help-block"></p>
            <div class="row">
                <div class="col-lg-12">
                    <div class="input-group">
                        <span class="input-group-addon">内容</span>
                        <input type="text" name="content" id="content" value="" class="form-control " placeholder="">
                    </div>
                </div>
            </div>
            <p class="help-block"></p>
            <div class="row">
                <div class="col-lg-12">
                    <div class="input-group">
                        <span class="input-group-addon">角色名</span>
                        <textarea class="form-control" rows="6" id="roles" placeholder="角色名，半角逗号分隔"></textarea>
                    </div>
                </div>
            </div>
            <p class="help-block"></p>
            <div class="row">
                <div class="col-lg-12">
                    <div class="input-group">
                        <span class="input-group-addon">道具ID</span>
                        <textarea class="form-control" rows="6" id="itemIds" placeholder="发送道具，半角逗号分隔"></textarea>
                    </div>
                </div>
            </div>
            <p class="help-block"></p>
            <div class="row">
                <div class="col-lg-12">
                    <div class="input-group">
                        <span class="input-group-addon">道具数量</span>
                        <textarea class="form-control" rows="6" id="itemNums" placeholder="道具数量，半角逗号分隔和道具ID一一对应，必须保持一致"></textarea>
                    </div>
                </div>
            </div>
            <p class="help-block"></p>
            <div class="form-actions">
                <button type="button" class="btn btn-primary" id="sub" data-loading-text="提交中...">发送</button>
            </div>
        </fieldset>
    </form>
</div>
<div class="container" id="datalist">

</div>
<script>
    $(function () {
        $("#sub").click(function (event) {
            event.preventDefault();
            var serverId = $("#serverId").val();
            var title = $("#title").val();
            var content = $("#content").val();
            var roles = $("#roles").val();
            var itemIds = $("#itemIds").val();
            var itemNums = $("#itemNums").val();
            if (serverId == 0) {
                $("#warn").html("<strong>错误!</strong> 请选择游戏大区");
                $("#warn").removeClass("hidden");
                btn.button('reset');
                return;
            }
            if (roles == '') {
                $("#warn").html("<strong>错误!</strong> 请填写发送角色");
                $("#warn").removeClass("hidden");
                btn.button('reset');
                return;
            }
            if (title == '') {
                $("#warn").html("<strong>错误!</strong> 请填写发送标题");
                $("#warn").removeClass("hidden");
                btn.button('reset');
                return;
            }
            if (content == '') {
                $("#warn").html("<strong>错误!</strong> 请填写发送内容");
                $("#warn").removeClass("hidden");
                btn.button('reset');
                return;
            }
            show_dialog({
                title: "发送确认",
                html: "该操作会有延迟性，确认发送？",
                submit_callback: function () {
                    $("#btnok").button('loading');
                    var url = "http://" + "<?php echo BASE_URL . "/gmt/src/admin.php/Home/Game/Mail/send/"; ?>";
                    $.ajax({
                        type: 'POST',
                        url: url,
                        cache: false,
                        dataType: "json",
                        data: {title: title, content: content, roles: roles, itemIds: itemIds, itemNums: itemNums, serverId: serverId, act: 1},
                        success: function (data) {
                            if (data.code == '1') {
                                var info = {
                                    url: "http://" + "<?php echo BASE_URL . "/gmt/src/admin.php/Home/Game/Mail/send/"; ?>",
                                    requestData: {id: data.info.id, serverId: data.info.serverId, act: 2}
                                };
                                gameRoundRequest(data, info);
                            }
                            else {
                                $(".modal-body").html('<div class="alert alert-danger" role="alert"><strong>error!</strong>' + data.msg + '</div>');
                                setTimeout(function () {
                                    $("#infoModal20140114").modal("hide");
                                }, 2000);
                            }
                        }
                    });
                }
            });
        })
    });
</script>
</body>
</html>