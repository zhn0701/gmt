<?php

namespace Home\Controller\Pub;

use Think\Controller;

class LoginController extends Controller {

    /**
     * 登录页
     */
    public function index() {
        //var_dump(I("session.access"));exit;
        if (I("session.access")) {            //有登录状态，直接跳到登录
            redirect(__APP__ . "/Home/Index",  0, "已登录...");
        }
        $this->display();
    }

    /**
     * 验证登录
     */
    public function login() {
        if (I("session.access")) {            //有登录状态，直接跳到登录
            redirect(__APP__ . "/Home/Index",  0, "已登录...");
        }
        if (!IS_POST) {
            $this->ajaxReturn(array('code' => 0, 'msg' => 'must post'));
        }
        $account = I('account');
        $password = I('password');
        //验证用户名密码
        $userModel = new \Home\Model\UserModel();
        $userInfo = $userModel->checkUser($account, $password);
        if (empty($userInfo)) {
            $this->ajaxReturn(array('code' => 0, 'msg' => '账号密码错误'));
        }
        if($userInfo['status'] == '1'){
            $this->ajaxReturn(array('code' => 0, 'msg' => '账号已锁定'));
        }
        $userInfo['lastLoginTime'] = TIMESTATMP;
        $userModel->data($userInfo)->save();
        //验证普通用户权限
        if ($userInfo['isadmin'] == '0') {
            $roleUserModel = new \Home\Model\RoleUserModel();
            $roleInfo = $roleUserModel->checkRole($userInfo['id']);
            if (empty($roleInfo)) {
                $this->ajaxReturn(array('code' => 0, 'msg' => '账号无操作权限'));
            }
            //获取用户组权限列表
            $rolePermissionModel = new \Home\Model\RolePermissionModel();
            $permissionList = $rolePermissionModel->getPermission($roleInfo);
        }
        //获取菜单列表
        $permissionModel = new \Home\Model\PermissionModel();
        $menuList = $permissionModel->select();
        if ($access = \Home\Lib\Access::saveAccess($userInfo, $roleInfo, $permissionList, $menuList)) {      //验证通过
            $_SESSION['user'] = $userInfo;
            $_SESSION['access'] = $access;
            $this->ajaxReturn(array('code' => 1, 'msg' => 'ok'));
        } else {
            $this->ajaxReturn(array('code' => 0, 'msg' => '获取权限失败'));
        }
    }
    
    public function logout(){
        if(!I("session.access")){
            redirect(__APP__ . "/Home/Pub/Login", 1, "登出...");
        }
//        unset($_SESSION['access']);
//        unset($_SESSION['user']);
        session_destroy();
        redirect(__APP__ . "/Home/Pub/Login",  1, "登出...");
    }

}
