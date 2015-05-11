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
    <div class="alert alert-danger hidden" role="alert" id='warn'>
        <strong>错误!</strong>
    </div>
    <div class="alert alert-success hidden" role="alert" id='success'>
        <strong>成功!</strong>
    </div>
    <div class="modal-body2">
        <form class="form-horizontal">
            <div class="form-group">
                <label for="inputName" class="col-sm-3 control-label">操作角色名</label>
                <div class="col-sm-4">
                    <?php echo $name; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputName" class="col-sm-3 control-label">删减道具ID</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="itemId" name="itemId" placeholder="删减道具ID">
                </div>
            </div>            
            <div class="form-group">
                <label for="inputPassword" class="col-sm-3 control-label">道具表</label>
                <div class="col-sm-4">
                    <select class="form-control" id='selectItem' name='selectItem'>
                        <option value='0'>呵呵</option>
                        <?php foreach ($item as $k => $v) { ?>                                    
                            <option value='<?php echo $k; ?>'><?php echo $k . ":" . $v; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>  
            <div class="form-group">
                <label for="inputName" class="col-sm-3 control-label">删减道具数量</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="itemNum" name="itemNum" placeholder="删减道具数量">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-4">
                    <input type="hidden" name='serverId' id='serverId' value='<?php echo $serverId; ?>'>
                    <input type="hidden" name='name' id='name' value='<?php echo $name; ?>'>
                    <button type="button" class="btn btn-primary" id="save"  data-loading-text="提交中...">提交</button>                           
                </div>
            </div>
        </form>
    </div>
    <script>
        $("#itemId").change(function () {
            $("#selectItem").val($(this).val());
        });
        $("#selectItem").change(function () {
            $("#itemId").val($(this).val());
        });
        $("#save").click(function () {
            var itemId = $("#itemId").val();
            var selectItem = $("#selectItem").val();
            var itemNum = $("#itemNum").val();
            var serverId = $("#serverId").val();
            var name = $("#name").val();
            if(itemId != selectItem){
                $("#warn").html("<strong>错误!</strong> 道具编号不正确");
                $("#warn").removeClass("hidden");
                return false;
            }
            if(itemNum == '' || isNaN(itemNum) ){
                $("#warn").html("<strong>错误!</strong> 道具数量必须是数字");
                $("#warn").removeClass("hidden");
                return false;
            }
            show_dialog({
                title: "修改确认",
                html: "该操作会有延迟性，确认修改？",
                submit_callback: function () {
                    $("#btnok").button('loading');

                    var url = "http://" + "<?php echo BASE_URL . "/gmt/src/admin.php/Home/Game/Role/delItem/"; ?>";
                    $.ajax({
                        type: 'GET',
                        url: url,
                        cache: false,
                        dataType: "json",
                        data: {itemId: itemId, itemNum: itemNum, serverId: serverId, name: name, act: 2},
                        success: function (data) {
                            var info = {
                                url: "http://" + "<?php echo BASE_URL . "/gmt/src/admin.php/Home/Game/Role/delItem/"; ?>",
                                requestData: {id: data.info.id, serverId: data.info.serverId, act: 3}
                            };
                            gameRoundRequest(data, info);
                        }
                    });
                }
            });

        });
    </script>
</body>
</html>