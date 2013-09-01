<?php
class Tofu_Error extends Tofu_Core
{
    protected $_objCommonConf;
    protected $_objErrorConf;

    /**
     * construct 
     * 
     * @param array $arrError 
     *
     * @access public
     * @return void
     */
    public function construct()
    {
        $this->_objCommonConf = Tofu_Error_CommonConf::getInstance();
    }

    public function setErrorConf(Tofu_Error_Conf $objConf)
    {
        $this->_objErrorConf = $objConf;
    }

    /**
     * getError 
     * 
     * @param int $intNo 
     *
     * @access public
     * @return array
     */
    public function getError($strFlag = 0)
    {
        //获取指定错误
        $strMessage = $this->_objErrorConf->$strFlag->message;
        $strPrompt = $this->_objErrorConf->$strFlag->prompt;
        $intCode = $this->_objErrorConf->$strFlag->code;

        //没取到，取默认
        if (empty($strMessage) || empty($strPrompt)) {
            $strMessage = $this->_objErrorConf->default->message;
            $strPrompt = $this->_objErrorConf->default->prompt;
            $intCode = $this->_objErrorConf->default->code;
        }
        //没取到，取公共错误默认
        if (empty($strMessage) || empty($strPrompt)) {
            $strMessage = $this->_objCommonConf->default->message;
            $strPrompt = $this->_objCommonConf->default->prompt;
            $intCode = $this->_objCommonConf->default->code;
        }
        $arrReturn['message'] = $strMessage;
        $arrReturn['prompt'] = $strPrompt;
        $arrReturn['code'] = $intCode;
        return $arrReturn;
    }
}
