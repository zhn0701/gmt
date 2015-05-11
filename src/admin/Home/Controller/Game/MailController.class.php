<?php

namespace Home\Controller\Game;

class MailController extends \Home\Controller\CommonController {
    public function _initialize() {
        parent::_initialize();
        $this->_selectList = $this->_getSelectList();
        $this->assign("select", $this->_selectList);       //下拉菜单数据，app,game,channel
    }

    public function index() {
        $this->display();
    }

    public function send() {
        if (IS_AJAX && I("act") == '1') {           //修改操作
            $itemIdList = array();
            $itemNumList = array();
            $serverId = I('serverId');
            $title = I("title");
            $content = I("content");
            $itemIds = I("itemIds");
            $itemNums = I("itemNums");
            $roleList = explode(",",I("roles"));
            if(!empty($itemIds)){
                $itemIdList = explode(",",$itemIds);
            }
            if(!empty($itemNums)){
                $itemNumList = explode(",",$itemNums);
            }
            if(count($itemIdList) != count($itemNumList)){
                $this->ajaxReturn(array("code" => 0, "msg" => "道具ID和道具数量不一一对应"));
            }
            $serverString = $this->_selectList->server[$serverId]['nstring'];
            $request = \Home\Lib\GMTJson::getSendMail($roleList, $itemIdList,$itemNumList,$title,$content,$serverString);
            $this->_addRequest($request, $serverId);
        } elseif (IS_AJAX && I("act") == '2') {
            $this->_roundRequest();
        } else {
            $this->ajaxReturn(array("code" => 0, "msg" => "参数异常"));
        }
    }


}
