<?php
define("ENVIRONMENT", "dev");
define("APP_PATH", realpath(dirname(__FILE__) . "/../"));
$objApp = Tofu_Init::init();
$objApp->bootstrap();
$request = new Yaf_Request_Simple("CLI", "Index", "Test", "index", array("id" => '2', "format" => 'serialize', "sign" => 'ohmygod'));
$objApp->getDispatcher()->dispatch($request);
