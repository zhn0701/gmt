<?php if (!defined('THINK_PATH')) exit();?><div class="col-md-12">
    <ul class="list-group">
        <li class="list-group-item active">角色信息<button type="button" class="btn btn-warning" id="delItem" data-name="<?php echo $list['rolename']; ?>" data-serverId="<?php echo $serverId; ?>" data-loading-text="提交中...">删减道具</button></li>
        <li class="list-group-item col-md-4">账号ID：<?php echo $list['accountid']; ?></li>
        <li class="list-group-item col-md-4">游戏区ID：<?php echo $list['zoneid']; ?></li>
        <li class="list-group-item col-md-4">角色名称：<?php echo $list['rolename']; ?></li>
        <li class="list-group-item col-md-4">角色类型：<?php echo $list['roletpid']; ?></li>
        <li class="list-group-item col-md-4">角色经验：<?php echo $list['roleexp']; ?></li>
        <li class="list-group-item col-md-4">角色体力：<?php echo $list['vitality']; ?></li>
        <li class="list-group-item col-md-4">金币：<?php echo $list['gold']; ?></li>
        <li class="list-group-item col-md-4">充值钻石：<?php echo $list['chargediamond']; ?></li>
        <li class="list-group-item col-md-4">绑定钻石：<?php echo $list['binddiamond']; ?></li>
        <li class="list-group-item col-md-4">等级：<?php echo $list['rolelevel']; ?></li>
        <li class="list-group-item col-md-4">星级：<?php echo $list['starlevel']; ?></li>
        <li class="list-group-item col-md-4">品级：<?php echo $list['quiality']; ?></li>
        <li class="list-group-item col-md-4">技能点：<?php echo $list['skillpoint']; ?></li>
        <li class="list-group-item col-md-4">PVP币：<?php echo $list['pvpcoin']; ?></li>
        <li class="list-group-item col-md-4">人气值：<?php echo $list['rolepop']; ?></li>
        <li class="list-group-item col-md-4">退出时场景ID：<?php echo $list['sceneid']; ?></li>
        <li class="list-group-item col-md-4">物理攻击：<?php echo $list['atk']; ?></li>
        <li class="list-group-item col-md-4">物理防御：<?php echo $list['def']; ?></li>
        <li class="list-group-item col-md-4">暴击：<?php echo $list['atkcrift']; ?></li>
        <li class="list-group-item col-md-4">暴击抗性：<?php echo $list['defcrift']; ?></li>
        <li class="list-group-item col-md-4">命中几率(1/10000)：<?php echo $list['hitrate']; ?></li>
        <li class="list-group-item col-md-4">避闪几率(1/10000)：<?php echo $list['missrate']; ?></li>
        <li class="list-group-item col-md-4">最大生命值：<?php echo $list['maxhp']; ?></li>
        <li class="list-group-item col-md-4">战斗力：<?php echo $list['combat']; ?></li>
        <li class="list-group-item col-md-4">背包上限：<?php echo $list['bagcount']; ?></li>
        <li class="list-group-item col-md-4">创建时间：<?php echo date("Y-m-d H:i:s", $list['createtime']); ?></li>
        <li class="list-group-item col-md-4">上次登录时间：<?php echo date("Y-m-d H:i:s", $list['lastlogintime']); ?></li>
        <li class="list-group-item col-md-4">上次退出时间：<?php echo date("Y-m-d H:i:s", $list['lastquittime']); ?></li>
        <li class="list-group-item col-md-4">技能更新时间：<?php echo date("Y-m-d H:i:s", $list['lastskillupdatetime']); ?></li>
        <li class="list-group-item col-md-4">VIP等级：<?php echo $list['viplevel']; ?></li>
        <li class="list-group-item col-md-4">VIP积分：<?php echo $list['vipscore']; ?></li>
        <li class="list-group-item col-md-4">活跃度：<?php echo $list['activedegree']; ?></li>
        <li class="list-group-item col-md-4">累积消费充值砖石：<?php echo $list['totalusechargediamond']; ?></li>
        <li class="list-group-item col-md-4">累积消费绑定钻石：<?php echo $list['totalusebinddiamond']; ?></li>
        <li class="list-group-item col-md-4">充值累积钻石：<?php echo $list['totalchargediamond']; ?></li>
        <li class="list-group-item col-md-4">无效标识，0有效，1无效：<?php echo $list['invalidflag']; ?></li>
        <li class="list-group-item col-md-3 text-center"><button type="button" class="btn btn-primary" id="bag" data-id="<?php echo $list['accountid']; ?>" data-serverId="<?php echo $serverId; ?>" data-loading-text="提交中...">背包</button></li>
        <li class="list-group-item col-md-3 text-center"><button type="button" class="btn btn-primary" id="sub" data-id="<?php echo $list['accountid']; ?>" data-serverId="<?php echo $serverId; ?>" data-loading-text="提交中...">任务</button></li>
        <li class="list-group-item col-md-3 text-center"><button type="button" class="btn btn-primary" id="sub" data-id="<?php echo $list['accountid']; ?>" data-serverId="<?php echo $serverId; ?>" data-loading-text="提交中...">装备</button></li>
        <li class="list-group-item col-md-3 text-center"><button type="button" class="btn btn-primary" id="sub" data-id="<?php echo $list['accountid']; ?>" data-serverId="<?php echo $serverId; ?>" data-loading-text="提交中...">好友</button></li>
    </ul>        
</div>