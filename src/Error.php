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
    public function construct(Tofu_Error_Conf $objConf)
    {
        $this->_objCommonConf = Tofu_Error_CommonConf::getInstance();
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
        $strMessage = $this->_objErrorConf->error->get($intNo)->message;
        $strPrompt = $this->_objErrorConf->error->get($intNo)->prompt;

        //没取到，取默认
        if (empty($strMessage) || empty($strPrompt)) {
            $intNo = $this->_objErrorConf->error->get('default')->no;
            $strMessage = $this->_objErrorConf->error->get($intNo)->message;
            $strPrompt = $this->_objErrorConf->error->get($intNo)->prompt;
        }
        //没取到，取公共错误默认
        if (empty($strMessage) || empty($strPrompt)) {
            $intNo = $this->_objCommonConf->error->get('default')->no;
            $strMessage = $this->_objCommonConf->error->get($intNo)->message;
            $strPrompt = $this->_objCommonConf->error->get($intNo)->prompt;
        }
        $arrReturn['no'] = $intNo;
        $arrReturn['message'] = $strMessage;
        $arrReturn['prompt'] = $strPrompt;
        return $arrReturn;
    }
}
