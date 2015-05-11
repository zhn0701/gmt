<?php

define('ROOT_DIR', dirname(__FILE__));
define('TIMESTATMP', time());
define('DS', DIRECTORY_SEPARATOR);
define('BUILD_DIR_SECURE', false);
define('APP_STATUS','test');
define('BIND_MODULE','Api');
define('BIND_CONTROLLER','Index');
define('APP_NAME', 'src');
define('APP_PATH', ROOT_DIR . DS . 'app' . DS);

define('APP_DEBUG', true);

require ROOT_DIR .DS. 'libs' .DS. 'ThinkPHP' .DS. 'ThinkPHP.php';