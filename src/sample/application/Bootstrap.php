<?php
class Bootstrap extends Yaf_Bootstrap_Abstract
{
    public function _initNamespace(Yaf_Dispatcher $dispatcher)
    {
        Yaf_Registry::set('app_namespace', array(MAIN_APP));
    }
}
