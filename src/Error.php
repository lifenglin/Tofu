<?php
class Tofu_Error extends Tofu_Core
{
    /**
     * _arrError 
     * 
     * @var array
     * @access private
     */
    protected $_arrError = array(
            0 => array('message' => 'success', 'prompt' => '成功'),
            1 => array('message' => 'internal error', 'prompt' => '内部错误'),
            );
    protected $_defaultErrorNo = 0;


    /**
     * construct 
     * 
     * @param array $arrError 
     *
     * @access public
     * @return void
     */
    public function construct($arrError)
    {
        $this->_arrError = array_merge($this->_arrError, $arrError);
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
        $arrError = $this->_arrError[$intNo];
        if (empty($arrError['message']) || empty($arrError['prompt'])) {
            $intNo = $this->_defaultErrorNo;
            $arrError = $this->_arrError[$intNo];
        }
        $arrReturn['no'] = $intNo;
        $arrReturn['message'] = $arrError['message'];
        $arrReturn['prompt'] = $arrError['prompt'];
        return $arrReturn;
    }
}
