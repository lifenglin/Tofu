<?php
/**
 * Tofu_Controller_Abstract
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   Tofu
 * @author    lifenglin <lifenglin1987@gmail.com>
 * @copyright 2013 lifenglin
 * @license   https://github.com/lifenglin/Tofu BSD Licence
 * @version   SVN: <svn_id>
 * @link      https://github.com/lifenglin/Tofu
 */

/**
 * Tofu_Controller_Abstract
 *
 * @category  PHP
 * @package   Tofu
 * @author    lifenglin <lifenglin1987@gmail.com>
 * @copyright 2013 lifenglin1987@gmail.com
 * @license   https://github.com/lifenglin/Tofu BSD Licence
 * @version   Release: <package_version>
 * @link      https://github.com/lifenglin/Tofu
 */
class Tofu_Controller_Abstract extends Yaf_Controller_Abstract
{
    private  $_arrResponse;
    protected $arrResponse = array();
    private $_objUiConfig;

    /**
     * init 
     * 1、检查ui配置
     * 2、初始化请求参数
     * 3、初始化相应格式
     * 出现错误时，设置请求错误error code，抛出异常
     *
     * @access public
     * @return void
     */
    public function init()
    {
        try {
            $this->error();
            $this->_initUiConfig();
            $this->_check();
            $this->_initRequestParams();
            $this->_initResponseFormat();
        } catch (Exception $e) {
            //error code
            throw new Tofu_Exception();
        }
    }

    /**
     * error 
     * 
     * @param int $intNo 
     *
     * @access protected
     * @return void
     */
    protected function error($intNo = 0)
    {
        //todo:读取错误配置
        $arrError = array();
        $this->_arrResponse['error'] = Tofu_Error::getInstance($arrError)->getError($intNo);
    }

    /**
     * _initUiConfig 
     * 1、根据模块、控制器、action组成flag
     * 2、用flag寻找需要的配置
     *
     * @access private
     * @return bool
     */
    private function _initUiConfig()
    {
        $strModuleName      = strtolower($this->getRequest()->getModuleName());
        $strControllerName  = strtolower($this->getRequest()->getControllerName());
        $strActionName      = strtolower($this->getRequest()->getActionName());
        $strFlag            = sprintf("%s.%s.%s", $strModuleName, $strControllerName, $strActionName);
        $this->_objUiConfig = new Yaf_Config_Ini(CONF_PATH."/ui_config.ini", $strFlag);
        return true;
    }

    /**
     * _check 
     * 检查请求方法、签名
     *
     * @access private
     * @return void
     */
    private function _check()
    {
        return $this->_checkMethod() && $this->_checkSign();
    }

    /**
     * _initRequestParams 
     * 1、得到数据字典
     * 2、从请求中得到参数，根据字典组装参数
     *
     * @access private
     * @return void
     */
    private function _initRequestParams()
    {
        $arrRequestConfig = unserialize($this->_objUiConfig->request);
        $objDictionary = new Yaf_Config_Ini(CONF_PATH . '/params_dictionary.ini');
        foreach ($arrRequestConfig as $arrConfig) {
            $strParam = $this->getRequest()->getParam($arrConfig['param_name']);
            if (null === $strParam && $arrConfig['is_required']) {
                die('error');
            }
            if (!$arrConfig['allow_empty'] && empty($strParam)) {
                $strParam = $arrConfig['default'];
                if (empty($strParam)) {
                    die('error');
                }
            }
            $strType = $objDictionary[$arrConfig['param_name']]['param_type'];
            $intLength = $objDictionary[$arrConfig['param_name']]['length'];
            $strExtra = $objDictionary[$arrConfig['param_name']]['extra'];
            $this->_arrRequest[$arrConfig['param_name']] = Tofu_Entity::getEntity($strType, $strParam, $intLength, $strExtra)->getValue();
        }
        return true;
    }

    /**
     * _initResponseFormat 
     * 1、从请求中取出format参数
     * 2、优先使用请求中format，其次为配置的format
     *
     * @access private
     * @return void
     */
    private function _initResponseFormat()
    {
        $strFormat = $this->getRequest()->getParam('format');
        $this->_strResponseFormat = $strFormat ? $strFormat : $this->_objUiConfig->response_format;
        if ($this->_strResponseFormat !== 'html') {
            Yaf_Dispatcher::getInstance()->disableView();
        }
    }

    /**
     * _checkMethod 
     * 检查本次请求的method是否在配置中
     *
     * @access private
     * @return void
     */
    private function _checkMethod()
    {
        if (false !== strpos($this->_objUiConfig->method, $this->getRequest()->getMethod(), 0)) {
            return true;
        } else {
            throw new Tofu_Exception();
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
        /*
        if ($strTemp = $this->_objUiConfig->sign) {
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
                throw new Tofu_Exception();
            }
        }
        */
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
        $arrResponseConfig = unserialize($this->_objUiConfig->response);
        foreach ($arrResponseConfig as $strParamName => $arrConfig) {
            $mixParam = isset($this->arrResponse[$strParamName]) ? $this->arrResponse[$strParamName] : $arrConfig['default'];
            $this->_setResponseParam($arrConfig['type'], $strParamName, $mixParam);
        }
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
        if ($mixParam instanceof Tofu_Entity) {
            $mixParam = $mixParam->toArray();
        } else {
            $mixParam = Tofu_Entity::getEntity($strType, $mixParam)->getValue();
        }
        $this->_arrResponse['data'][$strParamName] = $mixParam;
    }
}
