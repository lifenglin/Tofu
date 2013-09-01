<?php
abstract class Tofu_Conf extends Tofu_Core
{
    /**
     * _objConf 
     * 配置对象
     * @var string
     * @access protected
     */
    protected $_objConf = '';

    /**
     * _strConfPath 
     * 配置路径
     * @var string
     * @access protected
     */
    protected $_strConfPath = '';

    public function construct($strConfPath = '') 
    {   
        if ($strConfPath) {
            $this->setConfPath($strConfPath);
        }   
        $this->_objConf = new Yaf_Config_Ini($this->_getConfPath());
    }

    public function __get($strFlag)
    {
        return $this->_objConf->$strFlag;
    }

    public function get($strFlag)
    {
        return $this->_objConf->get($strFlag);
    }

    protected function _getConfPath()
    {
        return $this->_strConfPath;
    }

    public function setConfPath($strConfPath)
    {
        $this->_strConfPath = $strConfPath;
    }
}
