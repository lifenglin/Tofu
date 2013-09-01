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
    public function getError($strFlag = '')
    {
        $strMessage = '';
        $strPrompt = '';
        $intCode = 0;

        //获取指定错误
        if ($objConf = $this->_objErrorConf->$strFlag) {
            $strMessage = $objConf->message;
            $strPrompt = $objConf->prompt;
            $intCode = $objConf->code;
        }

        //没取到，取公用
        if (empty($strMessage) || empty($strPrompt)) {
            if ($objConf = $this->_objCommonConf->$strFlag) {
                $strMessage = $objConf->message;
                $strPrompt = $objConf->prompt;
                $intCode = $objConf->code;
            }
        }

        //没取到，取默认
        if (empty($strMessage) || empty($strPrompt)) {
            if ($objConf = $this->_objErrorConf->default) {
                $strMessage = $objConf->message;
                $strPrompt = $objConf->prompt;
                $intCode = $objConf->code;
            }
        }
        //没取到，取公共错误默认
        if (empty($strMessage) || empty($strPrompt)) {
            if ($objConf = $this->_objCommonConf->default) {
                $strMessage = $objConf->message;
                $strPrompt = $objConf->prompt;
                $intCode = $objConf->code;
            }
        }
        $arrReturn['message'] = strval($strMessage);
        $arrReturn['prompt'] = strval($strPrompt);
        $arrReturn['code'] = intval($intCode);
        return $arrReturn;
    }
}
