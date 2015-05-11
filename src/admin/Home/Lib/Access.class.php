<?php
namespace Home\Lib;

class Access{
    /**
     * 检测当前操作是否有权限
     * @param type $userinfo
     */
    public static function checkAccess($access,$controller,$action){
        if($controller == 'Index'){     //首页，直接通过
            return true;
        }
        list($module,$ctrl) = explode("/",$controller);
        if(self::_checkPermission($module,$ctrl,$action)){
            return true;
        }
        return false;
    }
    
    private function _checkPermission($module,$ctrl,$action){
        $access = I('session.access');
        $rs = 0;
        foreach($access as $m){
            if($m['code'] == $module && $m['permission'] == '1'){
                foreach($m['child'] as $c){
                    if($c['code'] == $ctrl && $c['permission'] == '1'){
                        foreach($c['child'] as $a){
                            if($a['code'] == $action && $a['permission'] == '1'){
                                $rs = 1;
                            }
                        }
                    }
                }
            }
        }
        return $rs;
    }
    
    /**
     * 设置并返回菜单和操作权限
     * @param type $userInfo
     * @param type $roleInfo
     * @param type $permission
     * @param type $menu
     * @return type
     */
    public static function saveAccess($userInfo,$roleInfo,$permission,$menu){
        foreach($permission as $v){
            $permissionList[$v['permissionId']] = 1;
        }
        $menuList = array();
        foreach($menu as $v){
            $menuList[$v['id']] = $v;            
        }
        foreach($menuList as $k => $v){
            if($userInfo['isadmin'] == '1' || $permissionList[$k] == '1'){         //有权限
                $v['permission'] = 1;
                
            }
            else{
                $v['permission'] = 0;
            }
            $menuList[$k] = $v;
        }
        //递归
        $rs = array();
        $rs = self::recursion($menuList,0);
        return $rs;
    }
    
    private function recursion($a,$pid = '0'){
        $t = array();
        foreach($a as $k => $v){
            if($v['pid'] == $pid){
                $v['child'] = self::recursion($a,$v['id']); 
                $t[] = $v;
            }
        }
        return $t;
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

