<?php

namespace Home\Controller\Admin;

class UserController extends \Home\Controller\CommonController {

    private $_rs = array('code' => 0, 'msg' => '');

    public function index() {
        $userModel = new \Home\Model\UserModel();
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

            $userModel = new \Home\Model\UserModel();
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
        $userModel = new \Home\Model\UserModel();
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
        if ($id == '1') {
            $this->_rs['msg'] = 'admin账号无法删除';
            $this->ajaxReturn($this->_rs);
        }
        $userModel = new \Home\Model\UserModel();
        if (!$userModel->where(array('id' => $id))->find()) {
            $this->_rs['msg'] = '该账号不存在';
            $this->ajaxReturn($this->_rs);
        }
        $userModel->startTrans();
        if ($userModel->where(array('id' => $id))->delete()) {
            $roleUserModel = new \Home\Model\RoleUserModel();
            if ($roleUserModel->where(array('userId' => $id))->delete() !== false) {          //删除role_user表里的关联
                $roleUserModel->commit();
                $this->_rs['msg'] = '删除账号成功';
                $this->_rs['code'] = 1;
                $this->ajaxReturn($this->_rs);
            } else {
                $roleUserModel->rollback();
                $this->_rs['msg'] = '删除账号失败';
                $this->ajaxReturn($this->_rs);
            }
        } else {
            $roleUserModel->rollback();
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

    public function setpwd() {
        if (IS_AJAX) {
            $oldpwd = I('oldpwd');
            $newpwd = I('newpwd');
            $repwd = I('repwd');
            if (empty($oldpwd) || empty($newpwd)) {
                $this->_rs['msg'] = '密码不可为空';
                $this->ajaxReturn($this->_rs);
            }
            if ($newpwd != $repwd) {
                $this->_rs['msg'] = '2次密码不一致';
                $this->ajaxReturn($this->_rs);
            }
            if ($oldpwd == $newpwd) {
                $this->_rs['msg'] = '新密码不能和旧密码一样';
                $this->ajaxReturn($this->_rs);
            }
            $userModel = new \Home\Model\UserModel();
            if ($info = $userModel->where(array('id' => $_SESSION['user']['id']))->find()) {
                if ($info['password'] == $oldpwd) {
                    $info['password'] = $newpwd;
                    if ($userModel->data($info)->save()) {
                        $_SESSION['user'] = $info;
                        $this->_rs['msg'] = '修改完成';
                        $this->_rs['code'] = 1;
                        $this->ajaxReturn($this->_rs);
                    } else {
                        $this->_rs['msg'] = '修改失败1';
                        $this->ajaxReturn($this->_rs);
                    }
                } else {
                    $this->_rs['msg'] = '旧密码不正确';
                    $this->ajaxReturn($this->_rs);
                }
            } else {
                $this->_rs['msg'] = "修改失败";
                $this->ajaxReturn($this->_rs);
            }
        }
        $this->assign("info", I("session.userinfo"));
        $this->display();
    }

}
