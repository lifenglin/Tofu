<?php
define("ENVIRONMENT", "dev");
define("APP_PATH", realpath(dirname(__FILE__) . "/../"));
$objApp = Tofu_Init::init();
$objApp->bootstrap();
$request = new Yaf_Request_Simple("POST", "Commit", "Thread", "Add", array('title' => 'hehe', 'content' => 'wagaga'));
$objApp->getDispatcher()->dispatch($request);
