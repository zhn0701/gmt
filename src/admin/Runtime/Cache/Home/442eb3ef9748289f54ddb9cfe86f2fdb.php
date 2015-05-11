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
        <h1>权限表<a class="btn btn-primary" id="add" href="javascript:void(0)">添加权限</a></h1>
    </header>
    <div class="col-md-12">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>模块</th>
                    <th>模块代码</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $module) { ?>                
                    <tr>
                        <td><?php echo $module['name']; ?></td>
                        <td  class="m" data-id='<?php echo $module['id']; ?>'><?php echo $module['code']; ?></td>
                        <td>
                            <i class="glyphicon glyphicon-edit"></i><a href="javascript:void(0)" class='pedit'  data-id='<?php echo $module['id'] ?>' data-toggle="tooltip" title="编辑">编辑</a>
                            <i class="glyphicon glyphicon-trash"></i><a class="cartoon-delete" href="javascript:void(0);" data-id="<?php echo $module['id'] ?>" data-toggle="tooltip" title="删除">删除</a>
                        </td>
                    </tr>
                    <tr id="s<?php echo $module['id']; ?>" class="hidden">
                        <td>&nbsp;&nbsp;&nbsp;|_</td>
                        <td>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>控制器</th>
                                        <th>控制器代码</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($module['child'] as $menu) { ?>
                                        <tr>
                                            <td><?php echo $menu['name']; ?></td>
                                            <td class="m" data-id='<?php echo $menu['id']; ?>'><?php echo $menu['code']; ?></td>
                                            <td>
                                                <i class="glyphicon glyphicon-edit"></i><a href="javascript:void(0)" class='pedit'  data-id='<?php echo $menu['id'] ?>' data-toggle="tooltip" title="编辑">编辑</a>
                                                <i class="glyphicon glyphicon-trash"></i><a class="cartoon-delete" href="javascript:void(0);" data-id="<?php echo $menu['id'] ?>" data-toggle="tooltip" title="删除">删除</a>
                                            </td>
                                        </tr>
                                        <tr id="s<?php echo $menu['id']; ?>" class="hidden">
                                            <td>&nbsp;&nbsp;&nbsp;|_</td>
                                            <td>
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>操作</th>
                                                            <th>操作代码</th>
                                                            <th>操作</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($menu['child'] as $action) { ?>
                                                            <tr>
                                                                <td><?php echo $action['name']; ?></td>
                                                                <td><?php echo $action['code']; ?></td>
                                                                <td>
                                                                    <i class="glyphicon glyphicon-edit"></i><a href="javascript:void(0)" class='pedit'  data-id='<?php echo $action['id'] ?>' data-toggle="tooltip" title="编辑">编辑</a>
                                                                    <i class="glyphicon glyphicon-trash"></i><a class="cartoon-delete" href="javascript:void(0);" data-id="<?php echo $action['id'] ?>" data-toggle="tooltip" title="删除">删除</a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    <?php } ?>                                        
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>            
        </table>
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
                            <label for="inputName" class="col-sm-3 control-label">名称</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="inputName" name="name" placeholder="填写名称，用于人识别，例如某个操作、菜单等">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputCode" class="col-sm-3 control-label">权限代码</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="inputCode" name="code" placeholder="填写具体模块、控制器、操作方法名，例如：User、add">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-3 control-label">树</label>
                            <div class="col-sm-9">
                                <select class="form-control" id='selectPid' name='pid'>
                                    <option value='0'>顶级模块</option>
                                    <?php foreach ($select as $k => $v) { ?>                                    
                                        <option value='<?php echo $k; ?>'><?php echo $v; ?></option>
                                    <?php } ?>
                                </select>
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
    <script>
        $(function () {
            $(".m").click(function (event) {        //隐藏显示下级列表
                event.preventDefault();
                var id = $(this).attr('data-id');
                if ($("#s" + id).hasClass("hidden")) {
                    $("#s" + id).removeClass('hidden');
                    $(this).parent().addClass("info");
                }
                else {
                    $("#s" + id).addClass('hidden');
                    $(this).parent().removeClass("info");
                }
            });
            $("#add").click(function (event) {
                event.preventDefault();
                $('#myModal').modal({show: true});

            });
            $("#closemodel").click(function (event) {
                window.location.reload();

            });
            $("#save").click(function (event) {
                event.preventDefault();
                var btn = $(this).button('loading')
                var name = $("#inputName").val();
                var code = $("#inputCode").val();
                var pid = $("#selectPid").val();
                var id = $("#myModalLabel").attr("data-id");
                var act = $("#myModalLabel").attr("data-act");
                var url = $("#url").val();
                if (name == '') {
                    $("#warn").html("<strong>错误!</strong> 名称不能为空");
                    $("#warn").removeClass("hidden");
                    btn.button('reset');
                    return false;
                }
                if (code == '') {
                    $("#warn").html("<strong>错误!</strong> 权限代码不能为空");
                    $("#warn").removeClass("hidden");
                    btn.button('reset');
                    return false;
                }
                // business logic...
                //btn.button('reset')
                var url = "http://" + "<?php echo BASE_URL . "/PayGateway_v2/src/admin.php/Home/Admin/Permission/"; ?>" + url;
                $.ajax({
                    type: 'POST',
                    data: {name: name, code: code, pid: pid, id: id, act: act},
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

            $(".pedit").click(function () {     //获取编辑内容
                event.preventDefault();
                var ele = $(this);
                var id = ele.attr('data-id');
                var url = "http://" + "<?php echo BASE_URL . "/PayGateway_v2/src/admin.php/Home/Admin/Permission" . "/edit"; ?>";
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

                            $("#myModalLabel").html("编辑权限" + data.data.name);
                            $("#inputName").val(data.data.name);
                            $("#inputCode").val(data.data.code);
                            $("#selectPid").val(data.data.pid);
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
                    html: "一旦删除不可恢复，该节点下的所有权限点记录都将一起删除，确认删除？",
                    submit_callback: function () {
                        $(".modal-backdrop").remove();
                        var id = ele.attr('data-id');
                        var url = "http://" + "<?php echo BASE_URL . "/PayGateway_v2/src/admin.php/Home/Admin/Permission" . "/del"; ?>";
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
        });
    </script>
    </body>
</html>