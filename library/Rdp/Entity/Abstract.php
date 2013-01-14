<?php
/**
 * Rdp_Entity_Abstract
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   Rdp
 * @author    lifenglin <lifenglin1987@gmail.com>
 * @copyright 2013 lifenglin
 * @license   https://github.com/lifenglin/rdp BSD Licence
 * @version   SVN: <svn_id>
 * @link      https://github.com/lifenglin/rdp
 */

/**
 * Rdp_Entity_Abstract
 *
 * @category  PHP
 * @package   Rdp
 * @author    lifenglin <lifenglin1987@gmail.com>
 * @copyright 2013 lifenglin1987@gmail.com
 * @license   https://github.com/lifenglin/rdp BSD Licence
 * @version   Release: <package_version>
 * @link      https://github.com/lifenglin/rdp
 */
class Rdp_Entity_Abstract extends Rdp_Core
{
    protected $strValue = null;
    protected $strType = null;

    //abstract protected function input($strValue);

    protected function output($strValue)
    {
        return $strValue;
    }

    public function construct($strValue)
    {
        $strValue !== NULL && $this->setValue($strValue);
    }

    public function setValue($strValue)
    {
        if (false !== $strValue = $this->input($strValue)) {
            $this->strValue = $strValue;
        } else {
            throw new Rdp_Exception();
        }
    }

    public function getValue()
    {
        return $this->output($this->strValue);
    }

    protected function setType($strType)
    {
        $this->strType = $strType;
    }

    public function getType()
    {
        return $this->strType;
    }
}
