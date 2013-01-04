<?php
define("ENVIRONMENT", "dev");
define("APP_PATH", realpath(dirname(__FILE__) . "/../"));
$objApp = Rdp_Init::init();
$objApp->bootstrap();
$request = new Yaf_Request_Simple("CLI", "Index", "Test", "index", array("para" => '2'));
$objApp->getDispatcher()->dispatch($request);
