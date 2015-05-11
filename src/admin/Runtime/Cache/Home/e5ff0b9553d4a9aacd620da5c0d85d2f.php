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
            <legend>角色</legend>            
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
                <div class="col-lg-4">
                    <div class="input-group">
                        <span class="input-group-addon">角色名称</span>
                        <input type="text" name="account" id="account" value="" class="form-control " placeholder="">
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
<div class="modal fade bs-example-modal-lg" id="role-user-Modal" tabindex="-10" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog"  style='width:600px'>
        <div class="modal-content">  
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="model-name"></span></h4>
            </div> 
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-4by3">
                    <iframe id="role-user-iframe" class="embed-responsive-item" src="" width='98.6%' height='700'></iframe>
                </div>

            </div>  
            <div class="modal-footer">   
                <button class="btn" data-dismiss="modal" >关闭</button>  
            </div> 
        </div>
    </div>
</div>
<script>
    $(function () {
        $("#sub").click(function (event) {
            event.preventDefault();
            var btn = $(this).button('loading')
            var serverId = $("#serverId").val();
            var account = $("#account").val();
            if (serverId == 0) {
                $("#warn").html("<strong>错误!</strong> 请选择游戏大区");
                $("#warn").removeClass("hidden");
                btn.button('reset');
                return;
            }
            if (account == '') {
                $("#warn").html("<strong>错误!</strong> 请填写游戏账号");
                $("#warn").removeClass("hidden");
                btn.button('reset');
                return;
            }
            $.ajax({
                url: "http://" + "<?php echo BASE_URL . "/gmt/src/admin.php/Home/Game/Role/getData/"; ?>",
                dataType: "html",
                cache: false,
                data: {serverId: serverId, account: account},
                type: "GET",
                success: function (data) {
                    $("#datalist").html(data);
                    $("#warn").addClass("hidden");
                    btn.button('reset');
                }
            })
        })
        $(document).on("click", "#bag", function (event) {
            event.preventDefault();
            var html = "";
            var id = $(this).attr('data-id');
            var serverId = $(this).attr("data-serverId");
            var url = "http://" + "<?php echo BASE_URL . "/gmt/src/admin.php/Home/Game/Role/getRoleBag/"; ?>";
            $.ajax({
                type: 'GET',
                url: url,
                cache: false,
                dataType: "json",
                data: {id: id,serverId:serverId},
                success: function (data) {
                    if (data.code == '1') {
                        html += '<table class="table table-bordered table-striped table-condensed"><thead><tr><th>物品位置索引</th><th>物品数量</th><th>物品类型</th><th>物品TPID</th></thead><tbody>';
                        for(var x in data.info){
                            html += '<tr><td>' + data.info[x].itemindex + '</td><td>' + data.info[x].itemcount + '</td><td>' + data.info[x].itemtype + '</td><td>' + data.info[x].itemtpid + '</td></tr>';
                        }
                        html += '</tbody></table>';
                        show_dialog({
                            title: "背包信息",
                            html: html
                        });
                    }
                    else {
                        show_dialog({
                            title: "背包信息",
                            html: "无访问权限"
                        });
                    }
                }
            });
        });
        $(document).on("click", "#delItem", function (event) {
            event.preventDefault();
            var name = $("#delItem").attr('data-name'); 
            var serverId = $("#delItem").attr('data-serverId'); 
            
            $(".modal-title").html(name + "删减道具和属性");
            var frameSrc = "http://" + "<?php echo BASE_URL . "/gmt/src/admin.php/Home/Game/Role/delItem/"; ?>" + "name/" + name + "/serverId/" + serverId + "/act/1";

            $('#role-user-Modal').modal({show: true});
            $('#role-user-iframe').attr("src", frameSrc);            
        });
    });
</script>
</body>
</html>