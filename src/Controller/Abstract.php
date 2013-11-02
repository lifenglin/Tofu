<?php
class Tofu_Controller_Abstract extends Yaf_Controller_Abstract
{
    public $actions = array();

    public function init()
    {
        $strModuleName = strtolower($this->getRequest()->getModuleName());
        $strControllerName = strtolower($this->getRequest()->getControllerName());
        $strActionName = strtolower($this->getRequest()->getActionName());
        $this->actions = array();
    }
}
