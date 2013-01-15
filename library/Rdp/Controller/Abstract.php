<?php
/**
 * Rdp_Controller_Abstract
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   Rdp
 * @author    lifenglin <lifenglin1987@gmail.com>
 * @copyright 2013 lifenglin
 * @license   https://github.com/lifenglin/rdp BSD Licence
 * @version   SVN: <svn_id>
 * @link      https://github.com/lifenglin/rdp
 */

/**
 * Rdp_Controller_Abstract
 *
 * @category  PHP
 * @package   Rdp
 * @author    lifenglin <lifenglin1987@gmail.com>
 * @copyright 2013 lifenglin1987@gmail.com
 * @license   https://github.com/lifenglin/rdp BSD Licence
 * @version   Release: <package_version>
 * @link      https://github.com/lifenglin/rdp
 */
class Rdp_Controller_Abstract extends Yaf_Controller_Abstract
{
    private  $_arrResponse = array('errno' => 0, 'data' => array());
    protected $arrResponse = array();

    /**
     * init 
     * 
     * @access public
     * @return void
     */
    public function init()
    {
        $this->_initActionConfig();
        $this->_check();
        $this->_initRequestParams();
        $this->_initResponseFormat();
    }

    /**
     * _initActionConfig 
     * 
     * @access private
     * @return void
     */
    private function _initActionConfig()
    {
        $strModuleName          = $this->getRequest()->getModuleName();
        $strControllerName      = $this->getRequest()->getControllerName();
        $strActionName          = $this->getRequest()->getActionName();
        $strFlag                = 
            sprintf("%s.%s.%s", $strModuleName, $strControllerName, $strActionName);
        $this->_objActionConfig = 
            new Yaf_Config_Ini(CONF_PATH."/controllers.ini", $strFlag);
        return true;
    }

    /**
     * _initRequestParams 
     * 
     * @access private
     * @return void
     */
    private function _initRequestParams()
    {
        $arrRequestConfig = unserialize($this->_objActionConfig->request);
        foreach ($arrRequestConfig as $strParamName => $arrConfig) {
            $this->_arrRequest[$strParamName] = 
                $this->_getRequestParam($arrConfig['type'], 
                        $strParamName, $arrConfig['default']);
        }
        return true;
    }

    /**
     * _initResponseFormat 
     * 
     * @access private
     * @return void
     */
    private function _initResponseFormat()
    {
        $arrResponseFormat        = 
            unserialize($this->_objActionConfig->responseFormat);
        $this->_strResponseFormat = $arrResponseFormat[0];
        if (in_array($this->getRequest()->getParam('format'), $arrResponseFormat)) {
            $this->_strRepsonseFormat = $this->getRequest()->getParam('format');
        }
        if ($this->_strResponseFormat !== 'html') {
            Yaf_Dispatcher::getInstance()->disableView();
        }
    }

    /**
     * _check 
     * 
     * @access private
     * @return void
     */
    private function _check()
    {
        $this->_checkMethod();
        $this->_checkSign();
    }

    /**
     * _checkMethod 
     * 
     * @access private
     * @return void
     */
    private function _checkMethod()
    {
        if (in_array($this->getRequest()->getMethod(), 
                    unserialize($this->_objActionConfig->method))) {
        } else {
            throw new Rdp_Exception();
        }
    }

    /**
     * _checkSign 
     * 
     * @access private
     * @return void
     */
    private function _checkSign()
    {
        if ($strTemp = $this->_objActionConfig->sign) {
            $arrParams = $this->getRequest()->getParams();
            $strSign   = strtolower($arrParams['sign']);
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

    /**
     * end 
     * 
     * @access public
     * @return void
     */
    public function end()
    {
        $this->_initResponseParams();
        $this->_setBody();
    }

    /**
     * _initResponseParams 
     * 
     * @access private
     * @return void
     */
    private function _initResponseParams()
    {
        $arrResponseConfig = unserialize($this->_objActionConfig->response);
        foreach ($arrResponseConfig as $strParamName => $arrConfig) {
            $mixParam = isset($this->arrResponse[$strParamName]) ? 
                $this->arrResponse[$strParamName] : $arrConfig['default'];
            $this->_setResponseParam($arrConfig['type'], $strParamName, $mixParam);
        }
    }

    /**
     * _getRequestParam 
     * 
     * @param str $strType         输入参数类型
     * @param str $strParamName    输入参数名
     * @param str $strDefaultParam 默认参数值
     *
     * @access private
     * @return obj Rdp_Entity
     */
    private function _getRequestParam($strType, $strParamName, 
            $strDefaultParam = null)
    {
        $strParam = $this->getRequest()->getParam($strParamName, $strDefaultParam);
        return Rdp_Entity::getEntity($strType, $strParam)->getValue();
    }

    /**
     * _setBody 
     * 
     * @access private
     * @return void
     */
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

    /**
     * _setResponseParam 
     * 
     * @param str   $strType      输出参数类型
     * @param str   $strParamName 输出参数名
     * @param mixed $mixParam     输出参数值
     *
     * @access private
     * @return void
     */
    private function _setResponseParam($strType, $strParamName, $mixParam = null)
    {
        if ($mixParam instanceof Rdp_Entity) {
            $mixParam = $mixParam->toArray();
        } else {
            $mixParam = Rdp_Entity::getEntity($strType, $mixParam)->getValue();
        }
        $this->_arrResponse['data'][$strParamName] = $mixParam;
    }
}
