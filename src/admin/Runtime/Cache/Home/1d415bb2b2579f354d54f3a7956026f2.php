<?php if (!defined('THINK_PATH')) exit();?>    <div class="col-md-12">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>订单号</th>
                    <th>应用</th>
                    <th>游戏</th>
                    <th>渠道</th>
                    <th>OS</th>
                    <th>游戏订单号</th>
                    <th>金额</th>
                    <th>时间</th>
                    <th>支付状态</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $v) { ?>                
                    <tr>
                        <td><small><?php echo $v['order_id']; ?></small></td>
                        <td><small><?php echo $v['app']; ?></small></td>
                        <td><small><?php echo $v['game']; ?></small></td>
                        <td><small><?php echo $v['channel']; ?></small></td>
                        <td><small><?php echo $v['os'] == '1' ? "ios" : "android"; ?></small></td>
                        <td><small><?php echo $v['game_order_no']; ?></small></td>
                        <td><small><?php echo $v['money']; ?></small></td>
                        <td><small><?php echo $v['datetime']; ?></small></td>
                        <td><small><?php echo $v['status'] == '1' ? "未通知游戏" : "已通知游戏"; ?></small></td>
                        <td>
                            <a href="javascript:void(0)" class='pview'  data-id='<?php echo $v['order_id'] ?>' data-toggle="tooltip" title="查看"><i class="glyphicon glyphicon-eye-open"></i>查看</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>            
        </table>
    </div>
    <nav><?php echo $page; ?></nav>