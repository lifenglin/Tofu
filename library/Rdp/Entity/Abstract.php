<?php
/**
 * Tofu_Entity_Abstract
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
 * Tofu_Entity_Abstract
 *
 * @category  PHP
 * @package   Tofu
 * @author    lifenglin <lifenglin1987@gmail.com>
 * @copyright 2013 lifenglin1987@gmail.com
 * @license   https://github.com/lifenglin/Tofu BSD Licence
 * @version   Release: <package_version>
 * @link      https://github.com/lifenglin/Tofu
 */
class Tofu_Entity_Abstract extends Tofu_Core
{
    protected $strValue = null;
    protected $strType  = null;

    //abstract protected function input($strValue);

    /**
     * output 
     * 
     * @param str $strValue 实体值
     * 
     * @access protected
     * @return str $strValue
     */
    protected function output($strValue)
    {
        return $strValue;
    }

    /**
     * construct 
     * 
     * @param str $strValue 实体值
     *
     * @access public
     * @return void
     */
    public function construct($strValue)
    {
        $strValue !== null && $this->setValue($strValue);
    }

    /**
     * setValue 
     * 
     * @param str $strValue 实体值
     *
     * @access public
     * @return void
     */
    public function setValue($strValue)
    {
        if (false !== $strValue = $this->input($strValue)) {
            $this->strValue = $strValue;
        } else {
            throw new Tofu_Exception();
        }
    }

    /**
     * getValue 
     * 
     * @access public
     * @return mixed value
     */
    public function getValue()
    {
        return $this->output($this->strValue);
    }

    /**
     * setType 
     * 
     * @param str $strType 实体值
     *
     * @access protected
     * @return void
     */
    protected function setType($strType)
    {
        $this->strType = $strType;
    }

    /**
     * getType 
     * 
     * @access public
     * @return str strType
     */
    public function getType()
    {
        return $this->strType;
    }
}
