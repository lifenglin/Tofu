<?php
abstract class Tofu_Action_Abstract extends Yaf_Action_Controller
{
    private $_arrResponse = array();
    private $_objActionConf;

    /**
     * execute 
     * 初始化action配置
     * 处理输入
     * 执行逻辑
     * 处理输出
     * @access public
     * @return void
     */
    public function execute()
    {
        try {
            $this->_init();
            $arrRequest = $this->_processRequest();
            $this->_execute($arrRequest);
        } catch (exception $objExc) {
            $this->_error($objExc->getMessage());
            trigger_error($objExc->getMessage(), E_USER_ERROR);
        }
        $this->_processResponse();
    }

    /**
     * _init 
     * 初始化action配置
     * @access private
     * @return void
     */
    private function _init()
    {
        $this->_objActionConf;
    }

    /**
     * _processRequest 
     * 处理输入
     * @access private
     * @return arrRequest
     */
    private function _processRequest()
    {
        $this->_checkMethod();
        $this->_checkSign();
        $arrRequest = $this->_checkRequest();
        return $arrRequest;
    }

    /**
     * _processResponse 
     * 处理输出
     * @access private
     * @return void
     */
    private function _processResponse()
    {
        $this->_arrResponse;
    }
    private function _checkMethod()
    {
    }
    private function _checkSign()
    {
    }
    abstract protected function _execute();
}
