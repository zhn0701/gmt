<?php

namespace Home\Controller\Admin;

class PermissionController extends \Home\Controller\CommonController {

    private $_rs = array('code' => 0, 'msg' => '');

    public function index() {
        $Model = new \Home\Model\PermissionModel();
        $rs = $Model->select();
        $list = $this->_recursion($rs);         //获取列表
        $select = $this->_getSelect($list);     //获取下拉数组
        $this->assign('list', $list);
        $this->assign("select", $select);
        $this->display();
    }

    private function _getSelect($list) {
        $a = array();
        foreach ($list as $v) {
            $a[$v['id']] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|-- " . $v['name'];
            if (count($v['child']) > 0) {
                foreach ($v['child'] as $v2) {
                    $a[$v2['id']] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|--" . $v2['name'];
                }
            }
        }
        return $a;
    }



    public function add() {
        if (IS_AJAX) {
            $name = I('post.name');
            $code = I('post.code');
            $pid = I('post.pid');

            $this->_checkForm();

            $model = new \Home\Model\PermissionModel();
            if ($model->where(array('pid' => $pid, 'code' => $code))->find()) {
                $this->_rs['msg'] = '该权限已存在';
                $this->ajaxReturn($this->_rs);
            }
            $insertData = array(
                'name' => $name,
                'code' => $code,
                'pid' => $pid,
            );
            if ($model->data($insertData)->add()) {
                $this->_rs['msg'] = '添加权限表成功';
                $this->_rs['code'] = 1;
                $this->ajaxReturn($this->_rs);
            }
        }
    }

    public function edit() {
        $act = I("act");
        $model = new \Home\Model\PermissionModel();
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
                'code' => I('code'),
                'pid' => I('pid'),
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
        $model = new \Home\Model\PermissionModel();
        if (!$model->where(array('id' => $id))->find()) {
            $this->_rs['msg'] = '该权限不存在';
            $this->ajaxReturn($this->_rs);
        }
        if ($count = $model->where("id = '" . $id ."' or pid = '" . $id . "'")->delete()) {
            $this->_rs['msg'] = '删除权限成功，共删除' . $count . "个权限节点";
            $this->_rs['code'] = 1;
            $this->ajaxReturn($this->_rs);
        } else {
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
        if (empty($code)) {
            $this->_rs['msg'] = '权限代码不可为空';
            $this->ajaxReturn($this->_rs);
        }
        if (!is_numeric($pid)) {
            $this->_rs['msg'] = '树选项异常' . json_encode(I("post."));
            $this->ajaxReturn($this->_rs);
        }
    }

}
