<?php

namespace Home\Controller\Game;

class AccountController extends \Home\Controller\CommonController {



    public function _initialize() {
        parent::_initialize();
        $this->_selectList = $this->_getSelectList();
        $this->assign("select", $this->_selectList);       //下拉菜单数据，app,game,channel
    }

    public function index() {
        $this->display();
    }

    public function getData() {
        if (IS_AJAX) {
            $serverId = I("serverId");
            $account = I("account");
            if (empty($serverId) || empty($account)) {
                echo "检索条件不正确";
                return;
            } else {
                $server = $this->_selectList->server[$serverId];
                $model = M("", "", "mysql://" . $server['account'] . ":" . $server['pwd'] . "@" . $server['host'] . "/" . $server['dbname'] . "#utf8");
                $list = $model->table('AccountData')->where(array("AccountName" => $account))->find();
                //print_r($list);
                if (empty($list)) {
                    echo "无结果";
                    return;
                }
                $this->assign("serverId", $serverId);
                $this->assign("list", $list);
            }
            $this->display();
        }
    }

    public function updatePwd() {
        if (IS_AJAX && I("act") == '1') {           //修改操作
            $name = I("name");
            $serverId = I("serverId");
            $pwd = I("pwd");
            $serverString = $this->_selectList->server[$serverId]['nstring'];
            $request = \Home\Lib\GMTJson::getUpdatePwd($name, $serverString, $pwd);
            $this->_addRequest($request, $serverId);
        } elseif (IS_AJAX && I("act") == '2') {
            $this->_roundRequest();
        } else {
            $this->ajaxReturn(array("code" => 0, "msg" => "参数异常"));
        }
    }



    //解冻或者冻结
    public function setState() {
        if (IS_AJAX && I("act") == '1') {             //正常操作
            $name = I("name");
            $serverId = I("serverId");
            $state = I("state");
            $serverString = $this->_selectList->server[$serverId]['nstring'];
            $request = \Home\Lib\GMTJson::getState($name, $serverString, $state);
            $this->_addRequest($request, $serverId);
        } elseif (IS_AJAX && I("act") == '2') {
            $this->_roundRequest();
        } else {
            $this->ajaxReturn(array("code" => 0, "msg" => "参数异常"));
        }
    }
}
