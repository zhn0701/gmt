<?php

namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller {
    protected $_selectList = array();       //所有选择信息
    public function _initialize() {
        //验证登录               
        //print_r(I("session.access"));
        if (!$access = I("session.access")) {         //没登录，跳转到登录页面
            redirect(__APP__ . "/Home/Pub/Login", 0, "还没登录...");
        }
        //记录操作
        \Home\Lib\Log::recordToMysql();
        //验证操作是否有权限
        if (!\Home\Lib\Access::checkAccess($access, CONTROLLER_NAME, ACTION_NAME)) {
            if (IS_AJAX) {
                $this->ajaxreturn(array('code' => 0, 'msg' => '无操作权限'));
            } else {
                $this->error('无操作权限');
            }
        }
        //初始化
        $this->assign('topMenu', $access);  //顶部栏
    }

    /**
     * 获取权限树结构
     * @param type $a
     * @param type $pid
     * @return type
     */
    protected function _recursion($a, $pid = '0') {
        $t = array();
        foreach ($a as $k => $v) {
            if ($v['pid'] == $pid) {
                $v['child'] = self::_recursion($a, $v['id']);
                $t[] = $v;
            }
        }
        return $t;
    }

    protected function _getSelectList() {
        $serverModel = new \Home\Model\ServerModel();
        $server = $serverModel->where(array('stype' => 1))->select();
        foreach($server as $v){
            $serverList[$v['id']] = $v;
        }
        $command = $serverModel->where(array('stype' => 2))->find();

        return (object) array(
            'server' => $serverList,
            'command' => $command,
            );
    }
    /**
     * 请求指令后轮循
     */
    protected function _roundRequest() {
        $id = I("id");
        $serverId = I("serverId");
        $server = $this->_selectList->command;
        $model = M("", "", "mysql://" . $server['account'] . ":" . $server['pwd'] . "@" . $server['host'] . "/" . $server['dbname'] . "#utf8");
        $list = $model->table('Command')->where(array("Id" => $id))->find();
        if (empty($list)) {
            $this->ajaxReturn(array("code" => 2, "msg" => "无此指令记录"));
        }
        if ($list['readflag'] != '1') {
            $this->ajaxReturn(array("code" => 0, "msg" => "正在读取..."));
        }
        if ($list['returnflag'] != '1') {
            $this->ajaxReturn(array("code" => 0, "msg" => "返回中..."));
        }
        $info = json_decode($list['reply'], true);
        if ($info['command_ret_t']['result'] != '0') {
            $this->ajaxReturn(array("code" => 2, "msg" => $info['command_ret_t']['info']));
        }
        $this->ajaxReturn(array("code" => 1, "msg" => "发送指令成功"));
    }
    
    /**
     * 添加指令操作
     * @param type $request
     * @param type $serverId
     */
    protected function _addRequest($request, $serverId) {
        $server = $this->_selectList->command;
        $model = M("", "", "mysql://" . $server['account'] . ":" . $server['pwd'] . "@" . $server['host'] . "/" . $server['dbname'] . "#utf8");
        $insertData = array(
            'Request' => $request,
            'Reply' => '',
            'ReadFlag' => 0,
            'ReturnFlag' => 0,
            'Time' => date("Y-m-d H:i:s"),
        );
        if ($lastId = $model->table("Command")->data($insertData)->add()) {
            $this->ajaxReturn(array("code" => 1, "info" => array('id' => $lastId, 'serverId' => $serverId), "msg" => "指令已发出，请等待..."));
        } else {
            $this->ajaxReturn(array("code" => 0, "info" => "指令记录错误"));
        }
    }
}
