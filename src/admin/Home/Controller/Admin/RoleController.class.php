<?php

namespace Home\Controller\Admin;

class RoleController extends \Home\Controller\CommonController {

    private $_rs = array('code' => 0, 'msg' => '');

    public function index() {
        $model = new \Home\Model\RoleModel();
        $count = $model->count();
        $page = new \Think\Page($count, 10);
        $show = $page->show();

        $list = $model->limit($page->firstRow . "," . $page->listRows)->select();
        //var_dump($list);
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display();
    }

    public function add() {
        if (IS_AJAX) {
            $name = I('post.name');
            $this->_checkForm();

            $model = new \Home\Model\RoleModel();
            if ($model->where(array('name' => $name))->find()) {
                $this->_rs['msg'] = '该角色组已存在';
                $this->ajaxReturn($this->_rs);
            }
            $insertData = array(
                'name' => $name,
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
        $model = new \Home\Model\RoleModel();
        if ($act == '1') {            //获取编辑信息
            $id = I('id');

            if (!$info = $model->where(array('id' => $id))->find()) {
                $this->_rs['msg'] = '该权限信息不存在';
            } else {
                $this->_rs['code'] = '1';
                $this->_rs['data'] = $info;
            }
        } elseif ($act == '2') {
            $this->_checkForm();
            $saveData = array(
                'id' => I('id'),
                'name' => I('name'),
            );
            if (!$model->data($saveData)->save()) {
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
        $model = new \Home\Model\RoleModel();
        if (!$model->where(array('id' => $id))->find()) {
            $this->_rs['msg'] = '该权限不存在';
            $this->ajaxReturn($this->_rs);
        }
        $model->startTrans();
        if ($count = $model->where(array('id' => $id))->delete()) {
            $roleUserModel = new \Home\Model\RoleUserModel();
            if ($roleUserModel->where(array('roleId' => $id))->delete()) {          //删除role_user表里的关联
                $roleUserModel->commit();
                $this->_rs['msg'] = '删除成功';
                $this->_rs['code'] = 1;
                $this->ajaxReturn($this->_rs);
            } else {
                $roleUserModel->rollback();
                $this->_rs['msg'] = '删除失败';
                $this->ajaxReturn($this->_rs);
            }
        } else {
            $roleUserModel->rollback();
            $this->_rs['msg'] = '删除失败';
            $this->ajaxReturn($this->_rs);
        }
    }

    private function _checkForm() {
        $name = I('post.name');
        $code = I('post.code');
        $pid = I('post.pid');
        if (empty($name)) {
            $this->_rs['msg'] = '名称不可为空';
            $this->ajaxReturn($this->_rs);
        }
    }

    /**
     * 账号授权列表
     */
    public function roleUser() {
        if (I("roleId") && IS_AJAX) {        //授权操作
            $insertData = array();
            $roleId = I("roleId");
            if (I("userIds")) {
                $userIds = explode(",", substr(I("userIds"), 0, -1));
                foreach ($userIds as $v) {
                    $insertData[] = array(
                        'roleId' => $roleId,
                        'userId' => $v,
                    );
                }
            }

            $roleUserModel = new \Home\Model\RoleUserModel();
            $roleUserModel->startTrans();
            if ($roleUserModel->where(array("roleId" => $roleId))->delete() === false) {           //删除之前的授权信息
                $roleUserModel->rollback();
                $this->_rs['msg'] = '授权账号失败，请重试1';
                $this->ajaxReturn($this->_rs);
            }
            if (!empty($insertData)) {
                if ($roleUserModel->addAll($insertData) === false) {
                    $roleUserModel->rollback();
                    $this->_rs['msg'] = '授权账号失败，请重试2';
                    $this->ajaxReturn($this->_rs);
                }
            }
            $roleUserModel->commit();
            $this->_rs['code'] = 1;
            $this->_rs['msg'] = '授权账号成功！！';
            $this->ajaxReturn($this->_rs);
        } else {                    //列表显示
            $id = I('id');
            if (empty($id)) {
                die("请求参数错误");
            }
            $userModel = new \Home\Model\UserModel();
            $userList = $userModel->select();

            $roleUserModel = new \Home\Model\RoleUserModel();
            $roleList = $roleUserModel->where(array('roleId' => $id))->select();

            $rs = $this->_getRoleCheckList($userList, $roleList);            //得到角色授权列表状态
            $this->assign('id', $id);
            $this->assign("list", $rs);
            $this->display();
        }
    }

    private function _getRoleCheckList($userList, $roleList) {
        foreach ($userList as $v) {
            $v['ischecked'] = 0;
            $user[$v['id']] = $v;
        }
        foreach ($roleList as $v) {
            $user[$v['userId']]['ischecked'] = 1;
        }
        return $user;
    }

    public function rolePermission() {
        if (IS_AJAX && I("roleId")) {
            $insertData = array();
            $roleId = I("roleId");
            if (I("permissionIds")) {
                $permissionIdList = explode(",", substr(I("permissionIds"), 0, -1));
                foreach ($permissionIdList as $v) {
                    $insertData[] = array(
                        'roleId' => $roleId,
                        'permissionId' => $v,
                    );
                }
            }

            $rolePermissionModel = new \Home\Model\RolePermissionModel();
            $rolePermissionModel->startTrans();
            if ($rolePermissionModel->where(array("roleId" => $roleId))->delete() === false) {           //删除之前的授权信息
                $rolePermissionModel->rollback();
                $this->_rs['msg'] = '授权权限失败，请重试1';
                $this->ajaxReturn($this->_rs);
            }
            if (!empty($insertData)) {
                if ($rolePermissionModel->addAll($insertData) === false) {
                    $rolePermissionModel->rollback();
                    $this->_rs['msg'] = '授权权限失败，请重试2';
                    $this->ajaxReturn($this->_rs);
                }
            }
            $rolePermissionModel->commit();
            $this->_rs['code'] = 1;
            $this->_rs['msg'] = '授权权限成功！！';
            $this->ajaxReturn($this->_rs);            
        } else {
            $id = I('id');
            if (empty($id)) {
                die("请求参数错误");
            }
            $permissionModel = new \Home\Model\PermissionModel();
            $rs = $permissionModel->select();

            $rolePermissionModel = new \Home\Model\RolePermissionModel();
            $rolePermissionList = $rolePermissionModel->where(array("roleId" => $id))->select();

            foreach ($rolePermissionList as $v) {
                $rolePermissionList[$v['permissionId']] = 1;
            }
            $permissionList = array();
            foreach ($rs as $v) {
                if ($rolePermissionList[$v['id']] == 1) {
                    $v['permission'] = 1;
                } else {
                    $v['permission'] = 0;
                }
                $permissionList[] = $v;
            }

            $permissionList = $this->_recursion($permissionList);         //获取权限展示列表，树状
            $this->assign('id', $id);
            $this->assign("list", $permissionList);
            $this->display();
        }
    }

}
