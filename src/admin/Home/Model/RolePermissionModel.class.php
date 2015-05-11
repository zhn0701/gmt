<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Model;

use Think\Model;

/**
 * Description of RoleModel
 *
 * @author pc
 */
class RolePermissionModel extends Model {

    //put your code here
    protected $trueTableName = 'role_permission';
    protected $dbName = 'rgz_admin';

    /**
     * 获取用户组的权限列表
     * @param type $roles
     * @return type
     */
    public function getPermission($roles){
        $str = '';
        foreach($roles as $v){
            $str .= $v['roleId'] . ",";
        }
        $a = array('roleId' => 1);
        $str = substr($str,0,-1);
        return $this->where(array('roleId' => array('in',$str)))->select();
        
    }
}
