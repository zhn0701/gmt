<?php

namespace Home\Model;

use Think\Model;

class UserModel extends Model {

    protected $trueTableName = 'user';
    protected $dbName = 'rgz_admin';

    /**
     * 判断用户帐号密码是否正确
     * @param type $account
     * @param type $password
     * @return boolean
     */
    public function checkUser($account,$password){
        $where = array('account' => $account);
        $info = $this->where($where)->find();
        if($info){
            if($info['password'] == $password){
                return $info;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
}
