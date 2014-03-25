<?php
include '../SinglePHP.class.php';
$config = array('APP_PATH'    => './App/',
                'DB_HOST'     =>'127.0.0.1',
                'DB_USER'     =>'root',
                'DB_PWD'      =>'toor',
                'DB_NAME'       =>'singlephp',
                'USE_SESSION' => true,
);
SinglePHP::getInstance($config)->run();
