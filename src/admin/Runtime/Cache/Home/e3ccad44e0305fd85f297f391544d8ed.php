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
            <?php foreach ($list as $v) { ?>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="userids" data-id="<?php echo $v['id']; ?>" value="1" <?php echo $v['ischecked'] == '1' ? "checked" : ""; ?>>
                        <?php echo $v['account'] . "-" . $v['name']; ?>
                    </label>
                </div>
            <?php } ?>
            <p></p>
            <div class="form-group">
                <div class="col-sm-offset-1">
                    <input type="hidden" name='roleid' id="roleid" value='<?php echo $id; ?>'>
                    <button type="button" class="btn btn-primary" id="save"  data-loading-text="提交中...">提交</button>                          
                </div>
            </div>
        </form>
    </div>
    <script>
        $("#save").click(function () {
            var userIds = '';
            $("input.userids:checked").each(function () {
                userIds += $(this).attr('data-id') + ',';
            });
            var roleId = $("#roleid").val();
            show_dialog({
                title: "操作确认",
                html: '确认选中用户授权用户组？',
                submit_callback: function () {
                    var url = "http://" + "<?php echo BASE_URL . "/PayGateway_v2/src/admin.php/Home/Admin/Role" . "/roleUser"; ?>";
                    $.ajax({
                        type: 'POST',
                        data: {roleId: roleId, userIds: userIds},
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