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
    <div class="container theme-showcase">
        <form class="form-horizontal">
            <?php foreach ($list as $module) { ?>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="permissionIds" data-id="<?php echo $module['id']; ?>" value="1" <?php echo $module['permission'] == '1' ? "checked" : ""; ?>>
                        <?php echo $module['name']; ?>
                    </label>
                </div>
                <?php if (count($module['child'])) { ?>
                    <?php foreach ($module['child'] as $menu) { ?>
                        <div class="checkbox">
                            &nbsp;&nbsp;&nbsp;&nbsp;|_
                            <label>
                                <input type="checkbox" class="permissionIds" data-id="<?php echo $menu['id']; ?>" value="1" <?php echo $menu['permission'] == '1' ? "checked" : ""; ?>>
                                <?php echo $menu['name']; ?>
                            </label>
                        </div>
                        <?php if (count($menu['child'])) { ?>
                            <div class="checkbox">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|_
                                <?php foreach ($menu['child'] as $action) { ?>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" class="permissionIds" data-id="<?php echo $action['id']; ?>" value="1" <?php echo $action['permission'] == '1' ? "checked" : ""; ?>>
                                        <?php echo $action['name']; ?>
                                    </label>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <p></p><br />
            <div class="form-group">
                <div class="col-sm-offset-1 col-sm-9">
                    <input type="hidden" name='roleid' id="roleid" value='<?php echo $id; ?>'>
                    <button type="button" class="btn btn-primary" id="save"  data-loading-text="提交中...">提交</button>                          
                </div>
            </div>
        </form>
    </div>
    <script>
        $("#save").click(function () {
            var permissionIds = '';
            $("input.permissionIds:checked").each(function () {
                permissionIds += $(this).attr('data-id') + ',';
            });
            var roleId = $("#roleid").val();
            show_dialog({
                title: "操作确认",
                html: '确认选中权限授权用户组？',
                submit_callback: function () {
                    var url = "http://" + "<?php echo BASE_URL . "/PayGateway_v2/src/admin.php/Home/Admin/Role" . "/rolePermission"; ?>";
                    $.ajax({
                        type: 'POST',
                        data: {roleId: roleId, permissionIds: permissionIds},
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
    </script>
</body>
</html>