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
class RoleUserModel extends Model {

    //put your code here
    protected $trueTableName = 'role_user';
    protected $dbName = 'rgz_admin';

    //获取该用户的角色组ID
    public function checkRole($userId){
        return $this->field(array("roleId"))
                ->where(array('userId' => $userId))
                ->select();
    }
}
