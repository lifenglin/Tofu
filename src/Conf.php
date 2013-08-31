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

    public function construct()
    {
        $this->_objConf = new Yaf_Config_Ini($this->_strConfPath);
    }

    public function __get($strFlag)
    {
        return $this->objConf->$strFlag;
    }
}
