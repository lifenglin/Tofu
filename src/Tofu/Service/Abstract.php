<?php
abstract class Tofu_Service_Abstract extends Tofu_Core
{
    private $_objController;
    public function construct(Tofu_Controller_Abstract $objController)
    {
        $this->_objController = $objController;
    }

    public function __call($strFuncName, $arrArgs)
    {
        call_user_func(array($this->_objController, $strFuncName), $arrArgs);
    }

    abstract public function execute($arrRequest);
}
