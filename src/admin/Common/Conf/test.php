<?php

return array(
    //测试环境数据库连接
    'DB_TYPE' => 'mysql', // 数据库类型
    'DB_HOST' => 'localhost', // 服务器地址
    'DB_NAME' => 'rgz_game', // 数据库名
    'DB_USER' => 'root', // 用户名
    'DB_PWD' => '', // 密码
    'DB_PORT' => '3306', // 端口
    'DB_PREFIX' => '', // 数据库表前缀
    'DB_CHARSET' => 'utf8', // 数据库编码
    'DB_DEBUG' => TRUE, // 数据库调试模式 开启后可以记录SQL日志
    
    //测试静态文件路径
    'STATIC_PUBLIC' => BASE_URL . STATIC_PUBLIC,
);

