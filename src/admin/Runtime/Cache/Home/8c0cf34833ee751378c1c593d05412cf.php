<?php if (!defined('THINK_PATH')) exit();?>    <div class="col-md-12">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>渠道</th>
                    <th>总额</th>
                    <th>订单数</th>
                    <th>付费人数</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $v) { ?>                
                    <tr>
                        <td><small><?php echo $v['channel']; ?></small></td>
                        <td><small><?php echo $v['allprice']; ?></small></td>
                        <td><small><?php echo $v['total']; ?></small></td>
                        <td><small><?php echo $v['usercount']; ?></small></td>
                    </tr>
                <?php } ?>
            </tbody>            
        </table>
    </div>