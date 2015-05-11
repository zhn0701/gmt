<?php
return array(
    //线上配置
    'DB_TYPE' => 'mysql', // 数据库类型
    'DB_HOST' => '192.168.2.27', // 服务器地址
    'DB_NAME' => 'pay_gateway', // 数据库名
    'DB_USER' => 'root', // 用户名
    'DB_PWD' => 'abshanghai', // 密码
    'DB_PORT' => '3306', // 端口
    'DB_PREFIX' => '', // 数据库表前缀
    'DB_CHARSET' => 'utf8', // 数据库编码
    'DB_DEBUG' => TRUE, // 数据库调试模式 开启后可以记录SQL日志
    
    //线上静态文件路径
    'STATIC_PUBLIC' => BASE_URL . STATIC_PUBLIC,
);
