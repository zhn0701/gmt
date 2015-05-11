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
    <header>
        <h1>公告列表<a class="btn btn-primary" id="add" href="javascript:void(0)">添加公告</a></h1>
    </header>
    <div class="col-md-12">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>标题</th>
                    <th>内容</th>
                    <th>游戏服</th>
                    <th>时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $v) { ?>                
                    <tr>
                        <td><?php echo $v['title']; ?></td>
                        <td><?php echo $v['info']; ?></td>
                        <td><?php echo $select->server[$v['serverId']]['name']; ?></td>
                        <td><?php echo date('Y-m-d H:i:s', $v['createTime']); ?></td>
                        <td>
                            <i class="glyphicon glyphicon-edit"></i><a href="javascript:void(0)" class='pedit'  data-id='<?php echo $v['id'] ?>' data-toggle="tooltip" title="编辑">编辑</a>
                            <i class="glyphicon glyphicon-trash"></i><a class="cartoon-delete" href="javascript:void(0);" data-id="<?php echo $v['id'] ?>" data-toggle="tooltip" title="删除">删除</a>
                            <i class="glyphicon glyphicon-trash"></i><a class="cartoon-send" href="javascript:void(0);" data-id="<?php echo $v['id'] ?>" data-toggle="tooltip" title="发送">发送</a>
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
                        <label for="inputTitle" class="col-sm-3 control-label">标题</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputTitle" name="title" placeholder="title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContent" class="col-sm-3 control-label">内容</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="3" id="inputContent" placeholder="内容"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="serverId" class="col-sm-3 control-label">游戏服</label>
                        <div class="col-sm-9">
                            <select class="form-control" id='serverId' name='serverId'>
                                <option value='0'>请选择</option>
                                <?php foreach ($select->server as $k => $v) { ?>                                    
                                    <option value='<?php echo $k; ?>'><?php echo $v['name']; ?></option>
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
            var url = "http://" + "<?php echo BASE_URL . "/gmt/src/admin.php/Home/Game/Notice" . "/edit"; ?>";
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

                        $("#myModalLabel").html("编辑" + data.data.title);
                        $("#inputTitle").val(data.data.title);
                        $("#inputContent").val(data.data.content);
                        $("#serverId").val(data.data.serverId);
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
                    var url = "http://" + "<?php echo BASE_URL . "/gmt/src/admin.php/Home/Game/Notice" . "/del"; ?>";
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
        $(".cartoon-send").click(function () {
            var ele = $(this);
            show_dialog({
                title: "发送确认",
                html: "本操作会有延迟性，确认发送？",                
                submit_callback: function () {
                    $("#btnok").button('loading');
                    var id = ele.attr('data-id');
                    var act = 1;
                    var url = "http://" + "<?php echo BASE_URL . "/gmt/src/admin.php/Home/Game/Notice" . "/send"; ?>";
                    $.ajax({
                        type: 'GET',
                        url: url,
                        cache: false,
                        dataType: "json",
                        data: {id: id,act:act},
                        success: function (data) {
                            if (data.code == '1') {
                                var info = {
                                    url: "http://" + "<?php echo BASE_URL . "/gmt/src/admin.php/Home/Game/Notice/send/"; ?>",
                                    requestData: {id: data.info.id, serverId: data.info.serverId, act: 2},
                                    flag:1
                                };
                                gameRoundRequest(data, info);
                            }
                            else {
                                $(".modal-body").html('<div class="alert alert-danger" role="alert"><strong>error!</strong>' + data.msg + '</div>');
                                setTimeout(function () {
                                    $("#infoModal20140114").modal("hide");
                                    window.location.reload();
                                }, 2000);
                            }
                        }
                    });
                }
            });
            return false;
        });
        $("#save").click(function (event) {
            event.preventDefault();
            var btn = $(this).button('loading')
            var title = $("#inputTitle").val();
            var content = $("#inputContent").val();
            var serverId = $("#serverId").val();
            var id = $("#myModalLabel").attr("data-id");
            var act = $("#myModalLabel").attr("data-act");
            var url = $("#url").val();
            if (title == '') {
                $("#warn").html("<strong>错误!</strong> 标题不能为空");
                $("#warn").removeClass("hidden");
                btn.button('reset');
                return false;
            }
            if (content == '') {
                $("#warn").html("<strong>错误!</strong> 内容不能为空");
                $("#warn").removeClass("hidden");
                btn.button('reset');
                return false;
            }
            if (serverId == 0) {
                $("#warn").html("<strong>错误!</strong> 选择游戏服");
                $("#warn").removeClass("hidden");
                btn.button('reset');
                return false;
            }
            // business logic...
            //btn.button('reset')
            var url = "http://" + "<?php echo BASE_URL . "/gmt/src/admin.php/Home/Game/Notice/"; ?>" + url;
            $.ajax({
                type: 'POST',
                data: {title: title, content: content, serverId: serverId, id: id, act: act},
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
    });
</script>
</body>
</html>