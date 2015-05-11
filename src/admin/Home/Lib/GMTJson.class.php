<?php

namespace Home\Lib;

class GMTJson {

    public static function getUpdatePwd($name, $serverString, $pwd) {
        return json_encode(array(
            'accountpwd_req_t' => array(
                'pwd' => $pwd,
                'zone' => $serverString,
                'accountname' => $name,
            ),
        ));
    }

    public static function getState($name, $serverString, $state) {
        return json_encode(array(
            'accountforbid_req_t' => array(
                'setstate' => intval($state),
                'zone' => $serverString,
                'accountname' => $name,
            ),
        ));
    }

    public static function getNotice($content, $serverString) {
        return json_encode(array(
            'broadcast_req_t' => array(
                'content' => $content,
                'zone' => $serverString,
            ),
        ));
    }

    public static function getDelItem($name, $itemId, $itemNum, $serverString) {
        return json_encode(array(
            'itemdeduct_req_t' => array(
                'itemid' => intval($itemId),
                'itemnum' => intval($itemNum),
                'name' => $name,
                'zone' => $serverString,
            ),
        ));
    }

    public static function getSendMail($roles, $itemIds, $itemNums,$title,$content, $serverString) {
        foreach($itemIds as $v){
            $t1[] = intval($v);
        }
        foreach($itemNums as $v){
            $t2[] = intval($v);
        }
        return json_encode(array(
            'mail_req_t' => array(
                'sender' => 'admin',
                'roles' => $roles,
                'itemids' => $t1,
                'itemnums' => $t2,
                'title' => $title,
                'content' => $content,
                'zone' => $serverString,
                'type' => 1
            ),
        ));
    }

}
