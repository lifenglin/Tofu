<?php
class Tofu_Bootstrap_Abstract extends Yaf_Bootstrap_Abstract
{
    public function _initEnv(Yaf_Dispatcher $objDispatcher)
    {
        Tofu_Env::getInstance();
    }

    public function _initNamespace(Yaf_Dispatcher $objDispatcher)
    {   
        Yaf_Registry::set('app_namespace', array(APP_NAME));
    }

    public function _initLog(Yaf_Dispatcher $objDispatcher)
    {
        set_error_handler(array(Tofu_Log::getInstance(), 'errorHandler'));
    }

    public function _initError(Yaf_Dispatcher $objDispatcher)
    {   
        $strErrorConf = Yaf_Application::app()->getConfig('application')->error->conf;
        $objErrorConf = Tofu_Error_Conf::getInstance($strErrorConf);
        Tofu_Error::getInstance()->setErrorConf($objErrorConf);
    }

    public function _initApplicationBootstrap(Yaf_Dispatcher $objDispatcher)
    {   
        if (method_exists($this, 'bootstrap')) {
            $this->bootstrap($objDispatcher);
        }   
    }
}
