<?php
class Rdp_Controller_Abstract extends Yaf_Controller_Abstract
{
    protected $strResonseFormat = 'html';
    protected $bolPostOnly = false;
    protected $strAjaxResponseFormat = 'json';

    protected $arrResponseFormatList = array('json', 'xml', 'html', 'serialize');

    protected $arrResponse = array('errno' => 0, 'data' => array());

    protected $strActionName = '';

    public function init()
    {
        $this->strActionName = $this->getRequest()->getActionName();
        $this->_check();
        $this->_load();
    }
    public function end()
    {
        $this->_initResponse();
        $this->_setBody();
    }
    private function _check()
    {
        if ($this->bolPostOnly[$this->strActionName] && !$this->getRequest()->isPost()) {
            //error
        }
    }
    private function _load()
    {
        $this->_initControllerConfigure();
        exit;
        $this->_initResponseFormat();
        $this->_initPageServiceparams();
    }
    private function _initControllerConfigure()
    {
        $config = new Yaf_Config_Ini(CONF_PATH."/controllers.ini", ENVIRONMENT);
        var_dump($config->database->params->host); 
        var_dump($config->database->params->dbname);
        var_dump($config->get("database.params.username"));
    }
    private function _initResponse()
    {
        foreach ($this->arrPageServiceReturnConfigure as $strReturnName => $arrReturn) {
            $mixParam = empty($this->arrPageServiceReturn[$strReturnName]) ? $arrReturn['default'] : $this->arrPageServiceReturn[$strReturnName];
            $this->_setResponseParam($arrReturn['type'], $strReturnName, $mixParam);
        }
    }
    private function _initResponseFormat()
    {
        if ($this->strResonseFormat[$this->strActionName] !== 'html' || $this->getRequest()->isXmlHttpRequest()) {
            Yaf_Dispatcher::getInstance()->disableView();
            //todo:改为枚举
            $this->strResonseFormat = $this->_getRequestParam('str', 'format', $this->strAjaxResponseFormat);
        }
    }
    private function _initPageServiceparams()
    {
        foreach ($this->arrPageServiceParamsConfigure as $strParamName => $arrParam) {
            $this->arrPageServiceParams[$strParamName] = $this->_getRequestParam($arrParam['type'], $strParamName, $arrParam['default']);
        }
    }
    private function _setBody()
    {
        if ($this->strResonseFormat === 'json') {
            $strBody = json_encode($this->arrResponse);
        } else if ($this->strResonseFormat === 'serialize') {
            $strBody = serialize($this->arrResponse);
        }
        $this->getResponse()->setBody($strBody);
    }
    private function _getRequestParam($strType, $strParamName, $strDefaultParam = NULL)
    {
        $strParam = $this->getRequest()->getParam($strParamName, $strDefaultParam);
        return Rdp_Entity::getEntity($strType, $strParam)->getValue();
    }
    private function _setResponseParam($strType, $strParamName, $mixParam = NULL)
    {
        if ($mixParam instanceof Rdp_Entity) {
            $mixParam = $mixParam->toArray();
        } else {
            $mixParam = Rdp_Entity::getEntity($strType, $mixParam)->getValue();
        }
        $this->arrResponse['data'][$strParamName] = $mixParam;
    }
}
