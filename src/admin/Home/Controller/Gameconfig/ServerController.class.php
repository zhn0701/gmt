<?php

namespace Home\Controller\Gameconfig;

class ServerController extends \Home\Controller\CommonController {

    private $_rs = array('code' => 0, 'msg' => '');

    public function index() {
        $userModel = new \Home\Model\ServerModel();
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
            $account = I('post.account');
            $password = I('post.password');
            $name = I('post.iname');
            $status = I('post.istatus');
            $isadmin = I('post.isadmin');

            $this->_checkForm();

            $userModel = new \Home\Model\ServerModel();
            if ($userModel->where(array('account' => $account))->find()) {
                $this->_rs['msg'] = '该账号已存在';
                $this->ajaxReturn($this->_rs);
            }
            $insertData = array(
                'account' => $account,
                'password' => $password,
                'name' => $name,
                'status' => $status,
                'isadmin' => $isadmin,
                'createTime' => TIMESTATMP,
                'lastLoginTime' => TIMESTATMP,
            );
            if ($userModel->data($insertData)->add()) {
                $this->_rs['msg'] = '添加账号成功';
                $this->_rs['code'] = 1;
                $this->ajaxReturn($this->_rs);
            }
        }
    }

    public function edit() {
        $act = I("act");
        $userModel = new \Home\Model\ServerModel();
        if ($act == '1') {            //获取编辑信息
            $id = I('id');

            if (!$userInfo = $userModel->where(array('id' => $id))->find()) {
                $this->_rs['msg'] = '该账号不存在';
            } else {
                $this->_rs['code'] = '1';
                $this->_rs['data'] = $userInfo;
            }
        } elseif ($act == '2') {
            $this->_checkForm();
            $saveData = array(
                'id' => I('id'),
                'account' => I('account'),
                'password' => I('password'),
                'name' => I('iname'),
                'status' => I('istatus'),
                'isadmin' => I('isadmin'),
            );
            if ($userModel->data($saveData)->save() === false) {
                $this->_rs['msg'] = '编辑账号失败';
            } else {
                $this->_rs['msg'] = '编辑账号成功';
                $this->_rs['code'] = 1;
            }
        }
        $this->ajaxReturn($this->_rs);
    }

    public function del() {
        $id = I('id');
        $userModel = new \Home\Model\ServerModel();
        if (!$userModel->where(array('id' => $id))->find()) {
            $this->_rs['msg'] = '该账号不存在';
            $this->ajaxReturn($this->_rs);
        }
        if ($userModel->where(array('id' => $id))->delete()) {
            $this->_rs['msg'] = '删除账号成功';
            $this->_rs['code'] = 1;
            $this->ajaxReturn($this->_rs);
        } else {
            $this->_rs['msg'] = '删除账号失败';
            $this->ajaxReturn($this->_rs);
        }
    }

    private function _checkForm() {
        $account = I('post.account');
        $password = I('post.password');
        $name = I('post.iname');
        $status = I('post.istatus');
        $isadmin = I('post.isadmin');
        if (empty($account)) {
            $this->_rs['msg'] = '账号不可为空';
            $this->ajaxReturn($this->_rs);
        }
        if (empty($password)) {
            $this->_rs['msg'] = '密码不可为空';
            $this->ajaxReturn($this->_rs);
        }
        if (empty($name)) {
            $this->_rs['msg'] = '昵称不可为空';
            $this->ajaxReturn($this->_rs);
        }
        if ($status != '0' && $status != '1') {
            $this->_rs['msg'] = '账号状态异常';
            $this->ajaxReturn($this->_rs);
        }
        if ($isadmin != '0' && $isadmin != '1') {
            $this->_rs['msg'] = '超级账号异常';
            $this->ajaxReturn($this->_rs);
        }
    }

}
