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
<div class="container theme-showcase">
    <header>
        <h1>角色组列表<a class="btn btn-primary" id="add" href="javascript:void(0)">添加角色</a></h1>
    </header>
    <div class="col-md-12">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>角色名称</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $v) { ?>                
                    <tr>
                        <td><?php echo $v['name']; ?></td>
                        <td>
                            <i class="glyphicon glyphicon-edit"></i><a href="javascript:void(0)" class='pedit'   data-id='<?php echo $v['id'] ?>'  data-toggle="tooltip" title="编辑">编辑</a>
                            <i class="glyphicon glyphicon-trash"></i><a class="cartoon-delete" href="javascript:void(0);" data-id="<?php echo $v['id'] ?>" data-toggle="tooltip" title="删除">删除</a>
                            <i class="glyphicon glyphicon-user"></i><a class="role-user" href="javascript:void(0);" data-id="<?php echo $v['id'] ?>" data-name="<?php echo $v['name']; ?>" data-toggle="tooltip" title="用户授权">用户授权</a>
                            <i class="glyphicon glyphicon-wrench"></i><a class="role-permission" href="javascript:void(0);" data-id="<?php echo $v['id'] ?>" data-name="<?php echo $v['name']; ?>" data-toggle="tooltip" title="权限授权">权限授权</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>            
        </table>
    </div>
    <nav><?php echo $page; ?></nav>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" data-id='0' data-act='0'>添加</h4>
            </div>
            <div class="alert alert-danger hidden" role="alert" id='warn'>
                <strong>错误!</strong>
            </div>
            <div class="alert alert-success hidden" role="alert" id='success'>
                <strong>成功!</strong>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="inputName" class="col-sm-3 control-label">角色组名</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputName" name="name" placeholder="角色组名">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <input type="hidden" name='url' id='url' value='add'>
                            <button type="button" class="btn btn-primary" id="save"  data-loading-text="提交中...">提交</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" id='closemodel'>关闭</button>                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" id="role-user-Modal" tabindex="-10" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog"  style='width:900px'>
        <div class="modal-content">  
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="model-name"></span></h4>
            </div> 
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-4by3">
                    <iframe id="role-user-iframe" class="embed-responsive-item" src="" width='99.6%' height='700'></iframe>
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
//        show_dialog({
//            title: "详细信息",
//            html: "<h1>111</h1>",
//            submit_callback: function () {
//                alert(this);
//            }
//        });
        $("#add").click(function (event) {
            event.preventDefault();
            $('#myModal').modal({show: true});

        });
        $("#closemodel").click(function (event) {
            window.location.reload();

        });
        $(".pedit").click(function () {     //获取编辑内容
            event.preventDefault();
            var ele = $(this);
            var id = ele.attr('data-id');
            var url = "http://" + "<?php echo BASE_URL . "/PayGateway_v2/src/admin.php/Home/Admin/Role" . "/edit"; ?>";
            $.ajax({
                type: 'POST',
                data: {id: id, act: 1},
                url: url,
                cache: false,
                dataType: "json",
                success: function (data) {
                    if (data.code == 1) {
                        $("#myModalLabel").attr("data-id", data.data.id);
                        $("#myModalLabel").attr("data-act", 2);

                        $("#myModalLabel").html("编辑角色组" + data.data.name);
                        $("#inputName").val(data.data.name);
                        $("#url").val("edit");

                        $('#myModal').modal({show: true});
                    }
                    else {
                        alert(data.msg);
                        return false;
                    }
                }
            });
        });
        $(".cartoon-delete").click(function () {
            var ele = $(this);
            show_dialog({
                title: "删除确认",
                html: "一旦删除不可恢复，确认删除？",
                submit_callback: function () {
                    $(".modal-backdrop").remove();
                    var id = ele.attr('data-id');
                    var url = "http://" + "<?php echo BASE_URL . "/PayGateway_v2/src/admin.php/Home/Admin/Role" . "/del"; ?>";
                    $.ajax({
                        type: 'POST',
                        data: {id: id},
                        url: url,
                        cache: false,
                        dataType: "json",
                        success: function (data) {
                            show_dialog({
                                title: "返回信息",
                                html: data.msg,
                                cancel: false,
                                submit_callback: function () {
                                    window.location.reload();
                                    return false;
                                }
                            });
                        }
                    });
                }
            });
            return false;
        });
        $("#save").click(function (event) {
            event.preventDefault();
            var btn = $(this).button('loading')
            var name = $("#inputName").val();
            var url = $("#url").val();
            var id = $("#myModalLabel").attr("data-id");
            var act = $("#myModalLabel").attr("data-act");
            // business logic...
            //btn.button('reset')
            var url = "http://" + "<?php echo BASE_URL . "/PayGateway_v2/src/admin.php/Home/Admin/Role/"; ?>" + url;
            $.ajax({
                type: 'POST',
                data: {name: name, id: id, act: act},
                url: url,
                cache: false,
                dataType: "json",
                success: function (data) {
                    if (data) {
                        if (data.code == 1) {
                            $("#success").html("<strong>成功!</strong> " + data.msg);
                            $("#success").removeClass("hidden");
                            window.location.reload();
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

        //角色授权用户编辑和显示
        $(".role-user").click(function (event) {
            event.preventDefault();
            var id = $(this).attr('data-id');
            
            $(".modal-title").html($(this).attr('data-name') + "账号授权");
            var frameSrc = "http://" + "<?php echo BASE_URL . "/PayGateway_v2/src/admin.php/Home/Admin/Role/"; ?>" + "roleUser/id/" + id;

            $('#role-user-Modal').modal({show: true});
            $('#role-user-iframe').attr("src", frameSrc);
        })
        
        //角色授权权限编辑和显示
        $(".role-permission").click(function (event) {
            event.preventDefault();
            var id = $(this).attr('data-id');
            
            $(".modal-title").html($(this).attr('data-name') + "权限授权");
            var frameSrc = "http://" + "<?php echo BASE_URL . "/PayGateway_v2/src/admin.php/Home/Admin/Role/"; ?>" + "rolePermission/id/" + id;

            $('#role-user-Modal').modal({show: true});
            $('#role-user-iframe').attr("src", frameSrc);
        })

    });
</script>
</body>
</html>