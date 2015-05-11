<?php

define('ROOT_DIR', dirname(__FILE__));
define('TIMESTATMP', time());
define('DS', DIRECTORY_SEPARATOR);
define('BUILD_DIR_SECURE', false);
define('APP_STATUS','test');
define('APP_NAME', 'src');
define('APP_PATH', ROOT_DIR . DS . 'admin' . DS);

define('BASE_URL',$_SERVER['SERVER_NAME']);
define('STATIC_PUBLIC','/gmt/src/admin/Public');   

define('APP_DEBUG', true);

require ROOT_DIR .DS. 'libs' .DS. 'ThinkPHP' .DS. 'ThinkPHP.php';