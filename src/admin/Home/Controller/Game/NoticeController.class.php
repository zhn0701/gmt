<?php

namespace Home\Controller\Game;

class NoticeController extends \Home\Controller\CommonController {

    private $_rs = array('code' => 0, 'msg' => '');

    public function _initialize() {
        parent::_initialize();
        $this->_selectList = $this->_getSelectList();
        $this->assign("select", $this->_selectList);       //下拉菜单数据，app,game,channel
    }

    public function index() {
        $userModel = new \Home\Model\NoticeModel();
        $count = $userModel->count();
        $page = new \Think\Page($count, 10);
        $show = $page->show();

        $list = $userModel->limit($page->firstRow . "," . $page->listRows)->select();
        //var_dump($list);
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display();
    }

    public function add() {
        if (IS_AJAX) {
            $title = I('post.title');
            $content = I('post.content');
            $serverId = I('post.serverId');

            $this->_checkForm();

            $model = new \Home\Model\NoticeModel();
            $insertData = array(
                'title' => $title,
                'info' => $content,
                'serverId' => $serverId,
                'createTime' => TIMESTATMP,
            );
            if ($model->data($insertData)->add()) {
                $this->_rs['msg'] = '添加成功';
                $this->_rs['code'] = 1;
                $this->ajaxReturn($this->_rs);
            }
        }
    }

    public function edit() {
        $act = I("act");
        $model = new \Home\Model\NoticeModel();
        if ($act == '1') {            //获取编辑信息
            $id = I('id');

            if (!$info = $model->where(array('id' => $id))->find()) {
                $this->_rs['msg'] = '该记录不存在';
            } else {
                $this->_rs['code'] = '1';
                $this->_rs['data'] = $info;
            }
        } elseif ($act == '2') {
            $this->_checkForm();
            $saveData = array(
                'id' => I('id'),
                'info' => I('title'),
                'content' => I('content'),
                'serverId' => I('serverId'),
            );
            if ($model->data($saveData)->save() === false) {
                $this->_rs['msg'] = '编辑失败';
            } else {
                $this->_rs['msg'] = '编辑成功';
                $this->_rs['code'] = 1;
            }
        }
        $this->ajaxReturn($this->_rs);
    }

    public function del() {
        $id = I('id');
        $model = new \Home\Model\NoticeModel();
        if (!$model->where(array('id' => $id))->find()) {
            $this->_rs['msg'] = '该记录不存在';
            $this->ajaxReturn($this->_rs);
        }
        if ($model->where(array('id' => $id))->delete()) {

            $this->_rs['msg'] = '删除成功';
            $this->_rs['code'] = 1;
            $this->ajaxReturn($this->_rs);
        } else {
            $this->_rs['msg'] = '删除失败';
            $this->ajaxReturn($this->_rs);
        }
    }

    private function _checkForm() {
        $title = I('post.title');
        $content = I('post.content');
        $serverId = I('post.serverId');
        if (empty($title)) {
            $this->_rs['msg'] = '标题不可为空';
            $this->ajaxReturn($this->_rs);
        }
        if (empty($content)) {
            $this->_rs['msg'] = '内容不可为空';
            $this->ajaxReturn($this->_rs);
        }
        if (empty($serverId)) {
            $this->_rs['msg'] = '选择游戏服';
            $this->ajaxReturn($this->_rs);
        }
    }

    public function send() {
        if (IS_AJAX && I("act") == '1') {           //修改操作
            $id = I("id");
            $model = new \Home\Model\NoticeModel();
            if (!$info = $model->where(array('id' => $id))->find()) {
                $this->ajaxReturn(array("code" => 0, "msg" => "该记录不存在"));
            }
            $serverId = $info['serverId'];
            $serverString = $this->_selectList->server[$serverId]['nstring'];
            $request = \Home\Lib\GMTJson::getNotice($info['info'], $serverString);
            $this->_addRequest($request, $serverId);
        } elseif (IS_AJAX && I("act") == '2') {
            $this->_roundRequest();
        } else {
            $this->ajaxReturn(array("code" => 0, "msg" => "参数异常"));
        }
    }

}
