<?php if (!defined('THINK_PATH')) exit();?><div class="col-md-12">
    <ul class="list-group">
        <li class="list-group-item active">账号信息</li>
        <li class="list-group-item">账号ID：<?php echo $list['accountid']; ?></li>
        <li class="list-group-item">账号：<?php echo $list['accountname']; ?></li>
        <li class="list-group-item">
            <form class="form-inline">
                <div class="input-group">
                    <span class="input-group-addon">密码</span>
                    <input type="text" name="pwd" id="pwd" value="" class="form-control" placeholder="">        

                </div>
                <button type="button" class="btn btn-primary" id="updatepwd" data-name="<?php echo $list['accountname']; ?>" data-serverId="<?php echo $serverId; ?>" data-loading-text="提交中...">修改密码</button>
            </form>
        </li>
        <li class="list-group-item">渠道：<?php echo $list['channel']; ?></li>
        <li class="list-group-item">平台：<?php echo $list['platform']; ?></li>
        <li class="list-group-item">BindFlag：<?php echo $list['bindflag']; ?></li>
        <li class="list-group-item">注册时间：<?php echo date("Y-m-d", $list['registertime']); ?></li>
        <li class="list-group-item">Forbidden：<?php echo $list['forbidden'] == '0' ? "正常" : "冻结"; ?></li>
        <li class="list-group-item">
            <button type="button" class="btn btn-primary" id="unlock" data-name="<?php echo $list['accountname']; ?>" data-serverId="<?php echo $serverId; ?>" data-loading-text="提交中...">解 冻</button>
            <button type="button" class="btn" id="lock" data-name="<?php echo $list['accountname']; ?>" data-serverId="<?php echo $serverId; ?>" data-loading-text="提交中...">冻 结</button>
        </li>
    </ul>
</div>