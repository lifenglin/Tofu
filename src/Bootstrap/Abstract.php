<?php
class Tofu_Bootstrap_Abstract extends Yaf_Bootstrap_Abstract
{
    public function _initEnv(Yaf_Dispatcher $objDispatcher)
    {
        Tofu_Env::getInstance();
    }

    public function _initLog(Yaf_Dispatcher $objDispatcher)
    {
        Tofu_Log::getInstance();
    }

    public function _initNamespace(Yaf_Dispatcher $objDispatcher)
    {   
        Yaf_Registry::set('app_namespace', array(APP_NAME));
    }
}
