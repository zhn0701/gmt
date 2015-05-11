<?php

namespace Home\Controller\Game;

class RoleController extends \Home\Controller\CommonController {

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
                $list = $model->table('RoleData')->where(array("RoleName" => $account))->find();
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

    public function getRoleBag() {
        $serverId = I("serverId");
        $accountId = I("id");
        $server = $this->_selectList->server[$serverId];
        $model = M("", "", "mysql://" . $server['account'] . ":" . $server['pwd'] . "@" . $server['host'] . "/" . $server['dbname'] . "#utf8");
        $list = $model->table('RoleBagData')->where(array("AccountID" => $accountId))->select();     
        if(empty($list)){
            $this->ajaxReturn(array('code' => 0, 'info' => $list));
        }
        $this->ajaxReturn(array('code' => 1, 'info' => $list));
    }
    
    public function delItem(){
        if(I('act') == '1'){            //获取编辑信息
            $serverId = I('serverId');
            $name = I('name');
            $serverString = $this->_selectList->server[$serverId]['nstring'];
            //获取XML
            $xml = simplexml_load_file(C('XML_ITEM'));
            $itemSelect = array();
            foreach($xml->item as $items){
                $itemSelect[(string)$items->attributes()->f_id] = (string)$items->attributes()->f_name;
            }
            $this->assign("name",$name);
            $this->assign("serverId",$serverId);
            $this->assign("item",$itemSelect);
            $this->display();
        }
        elseif (I("act") == '2') {           //修改操作
            $name = I("name");
            $itemId = I("itemId");
            $itemNum = I("itemNum");
            $serverId = I("serverId");
            $serverString = $this->_selectList->server[$serverId]['nstring'];
            $request = \Home\Lib\GMTJson::getDelItem($name, $itemId,$itemNum,$serverString);
            $this->_addRequest($request, $serverId);
        } elseif (I("act") == '3') {
            $this->_roundRequest();
        } else {
            $this->ajaxReturn(array("code" => 0, "msg" => "参数异常"));
        }
    }
    
}
