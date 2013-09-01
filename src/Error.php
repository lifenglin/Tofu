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
    public function getError($intNo = 0)
    {
        //获取指定错误
        $strMessage = $this->_objErrorConf->error->get("code$intNo")->message;
        $strPrompt = $this->_objErrorConf->error->get("code$intNo")->prompt;

        //没取到，取默认
        if (empty($strMessage) || empty($strPrompt)) {
            $intNo = $this->_objErrorConf->error->get('default')->no;
            $strMessage = $this->_objErrorConf->error->get("code$intNo")->message;
            $strPrompt = $this->_objErrorConf->error->get("code$intNo")->prompt;
        }   
        //没取到，取公共错误默认
        if (empty($strMessage) || empty($strPrompt)) {
            $intNo = $this->_objCommonConf->error->get('default')->no;
            $strMessage = $this->_objCommonConf->error->get("code$intNo")->message;
            $strPrompt = $this->_objCommonConf->error->get("code$intNo")->prompt;
        }   
        $arrReturn['no'] = $intNo;
        $arrReturn['message'] = $strMessage;
        $arrReturn['prompt'] = $strPrompt;
        return $arrReturn;
    }
}
