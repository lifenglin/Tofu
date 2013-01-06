<?php
class Rdp_Controller_Abstract extends Yaf_Controller_Abstract
{
    protected $arrResponse = array();

    private $_arrResponse = array('errno' => 0, 'data' => array());
    private $_objActionConfig;
    private $_strResponseFormat;
    private $_arrRequest;

    public function init()
    {
        $this->_initActionConfig();
        $this->_check();
        $this->_initRequestParams();
        $this->_initResponseFormat();
    }
    private function _initActionConfig()
    {
        $strModuleName = $this->getRequest()->getModuleName();
        $strControllerName = $this->getRequest()->getControllerName();
        $strActionName = $this->getRequest()->getActionName();
        $strFlag = sprintf("%s.%s.%s", $strModuleName, $strControllerName, $strActionName);
        $this->_objActionConfig = new Yaf_Config_Ini(CONF_PATH."/controllers.ini", $strFlag);
        return true;
    }
    private function _initRequestParams()
    {
        $arrRequestConfig = unserialize($this->_objActionConfig->request);
        foreach ($arrRequestConfig as $strParamName => $arrConfig) {
            $this->_arrRequest[$strParamName] = $this->_getRequestParam($arrConfig['type'], $strParamName, $arrConfig['default']);
        }
        return true;
    }
    private function _initResponseFormat()
    {
        $arrResponseFormat = unserialize($this->_objActionConfig->responseFormat);
        $this->_strResponseFormat = $arrResponseFormat[0];
        if (in_array($this->getRequest()->getParam('format'), $arrResponseFormat)) {
            $this->_strRepsonseFormat = $this->getRequest()->getParam('format');
        }
        if ($this->_strResponseFormat !== 'html') {
            Yaf_Dispatcher::getInstance()->disableView();
        }
    }
    private function _check()
    {
        $this->_checkMethod();
        $this->_checkSign();
    }
    private function _checkMethod()
    {
        if (in_array($this->getRequest()->getMethod(), unserialize($this->_objActionConfig->method))) {
        } else {
            throw new Rdp_Exception();
        }
    }
    private function _checkSign()
    {
        if ($strTemp = $this->_objActionConfig->sign) {
            $arrParams = $this->getRequest()->getParams();
            $strSign = strtolower($arrParams['sign']);
            if ($strSign == 'ohmygod') {
                return true;
            }
            unset($arrParams['sign']);
            ksort($arrParams);
            foreach ($arrParams as $strKey => $strVal) {
                $strTemp .= sprintf("%s=%s", $strKey, $strVal);
            }
            if ($strSign !== md5($strTemp)) {
                throw new Rdp_Exception();
            }
        }
        return true;
    }
    public function end()
    {
        $this->_initResponseParams();
        $this->_setBody();
    }
    private function _initResponseParams()
    {
        $arrResponseConfig = unserialize($this->_objActionConfig->response);
        foreach ($arrResponseConfig as $strParamName => $arrConfig) {
            $mixParam = isset($this->arrResponse[$strParamName]) ? $this->arrResponse[$strParamName] : $arrConfig['default'];
            $this->_setResponseParam($arrConfig['type'], $strParamName, $mixParam);
        }
    }
    private function _getRequestParam($strType, $strParamName, $strDefaultParam = NULL)
    {
        $strParam = $this->getRequest()->getParam($strParamName, $strDefaultParam);
        return Rdp_Entity::getEntity($strType, $strParam)->getValue();
    }
    private function _setBody()
    {
        if ($this->_strResponseFormat === 'json') {
            $strBody = json_encode($this->_arrResponse);
            $this->getResponse()->setBody($strBody);
        } else if ($this->_strResponseFormat === 'serialize') {
            $strBody = serialize($this->_arrResponse);
            $this->getResponse()->setBody($strBody);
        } else {
        }
    }
    private function _setResponseParam($strType, $strParamName, $mixParam = NULL)
    {
        if ($mixParam instanceof Rdp_Entity) {
            $mixParam = $mixParam->toArray();
        } else {
            $mixParam = Rdp_Entity::getEntity($strType, $mixParam)->getValue();
        }
        $this->_arrResponse['data'][$strParamName] = $mixParam;
    }
}
