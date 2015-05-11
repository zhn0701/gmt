/*
 * 弹出默认对话框
 * 参数：
 *      id：div标签
 *      title：弹出窗口标题
 *      html：弹出框内容
 *      submit：是否显示确认按钮
 *      submit_text：确认按钮内文字
 *      submit_callback：确认按钮点击触发函数，该函数返回 true 则窗口关闭
 *      cancel:是否显示取消按钮
 *      cancel_text：取消按钮的文字
 *      close：是否显示右上角关闭按钮
 *
 * show_dialog({
 *     title: "详细信息",
 *     html: "是否确认要删除",
 *     submit_callback: function() {
 *         alert(this);
 *     }
 * });
 */
var show_dialog = function (settings) {
    if (typeof jQuery == 'undefined') {
        return;
    }

    // 初始化配置
    settings = jQuery.extend({},
            {
                id: "infoModal20140114",
                title: "提醒",
                html: "",
                submit: false,
                submit_text: '确定',
                submit_callback: null,
                cancel: false,
                cancel_text: '取消',
                close: true
            },
    settings);

    var show_html = "";
    show_html += "        <div class=\"modal fade\" id=\"" + settings.id + "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">";
    show_html += "            <div class=\"modal-dialog\">";
    show_html += "                <div class=\"modal-content\">";
    show_html += "                    <div class=\"modal-header\">";
    if (settings.close) {
        show_html += "                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>";
    }
    show_html += "                        <h3 class=\"modal-title\">" + settings.title + "</h3>";
    show_html += "                    </div>";
    show_html += "                    <div class=\"modal-body\">";
    show_html += settings.html;
    show_html += "                    </div>";
    show_html += "                    <div class=\"modal-footer\">";
    if (settings.cancel || settings.submit_callback) {
        show_html += "                        <a href=\"#\" class=\"btn\" data-dismiss=\"modal\" >" + settings.cancel_text + "</a>";
    }
    if (settings.submit || settings.submit_callback) {
        show_html += "                        <a href=\"#\" class=\"btn btn-primary\" id=\"btnok\"  data-loading-text=\"提交中...\">" + settings.submit_text + "</a>";
    }
    show_html += "                    </div>";
    show_html += "                </div>";
    show_html += "            </div>";
    show_html += "        </div>";

    if (jQuery("#" + settings.id + "").length) {
        jQuery("#" + settings.id + "").replaceWith(show_html);
    } else {
        jQuery("body").append(show_html);
    }

    jQuery("#" + settings.id + "").modal('show');
    if (settings.submit_callback) {
        $("#" + settings.id + " a.btn-primary").unbind("click").bind("click",
                function () {
                    if (settings.submit_callback()) {
                        jQuery("#" + settings.id + "").modal('hide');
                    }
                }
        );
    }
}

var gameRoundRequest = function (data, info) {
    $(".modal-body").html('<div class="alert alert-info" role="alert">' + data.msg + '</div>');
    var t = setInterval(function () {
        $.ajax({
            type: 'GET',
            url: info.url,
            cache: false,
            dataType: "json",
            data: info.requestData,
            success: function (data) {
                if (data.code == '1') {
                    clearTimeout(t);
                    $(".modal-body").html('<div class="alert alert-success" role="alert"><strong>ok!</strong>' + data.msg + '</div>');
                    setTimeout(function () {
                        $("#infoModal20140114").modal("hide");
                        if(info.flag == 1){         //根据标识来确定是否刷新页面
                            window.location.reload();
                        }
                    }, 1000);
                    //clearTimeout(s);
                }
                else if (data.code == '0') {
                    $(".modal-body").html('<div class="alert alert-info" role="alert">' + data.msg + '</div>');
                }
                else if (data.code == '2') {
                    clearTimeout(t);
                    $(".modal-body").html('<div class="alert alert-danger" role="alert"><strong>error!</strong>' + data.msg + '</div>');
                    setTimeout(function () {
                        $("#infoModal20140114").modal("hide");
                        window.location.reload();
                    }, 2000);
                }
            }
        });
    }, 1000);
}