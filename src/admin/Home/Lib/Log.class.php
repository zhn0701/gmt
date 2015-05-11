<?php

namespace Home\Lib;

class Log {
    public static function recordToMysql(){
        $insertData = array(
            'controller' => CONTROLLER_NAME,
            'action' => ACTION_NAME,
            'url' => $_SERVER['REQUEST_URI'],
            'account' => $_SESSION['user']['account'],
            'accountId' => $_SESSION['user']['id'],
            'param' => json_encode(array('post' => I('post.'),'get' => I('get.'))),
            'createTime' => time(),
            'ip' => get_client_ip(),
        );   
        $model = new \Home\Model\LogModel();
        $model->data($insertData)->add();
    }
}
