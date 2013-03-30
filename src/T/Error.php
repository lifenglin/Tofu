<?php
/**
 * Tofu_Error
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
 * Tofu_Error
 *
 * @category  PHP
 * @package   Tofu
 * @author    lifenglin <lifenglin1987@gmail.com>
 * @copyright 2013 lifenglin1987@gmail.com
 * @license   https://github.com/lifenglin/Tofu BSD Licence
 * @version   Release: <package_version>
 * @link      https://github.com/lifenglin/Tofu
 */
class Tofu_Error extends Tofu_Core
{
    /**
     * _arrError 
     * 
     * @var array
     * @access private
     */
    private $_arrError = array(0 => array('message' => 'success', 'prompt' => '成功'));

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
        return array('no' => $intNo, 'message' => $arrError['message'], 'prompt' => $arrError['prompt']);
    }
}
