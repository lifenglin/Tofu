<?php
/**
 * Rdp_Entity_Str
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
 * Rdp_Entity_Str
 *
 * @category  PHP
 * @package   Rdp
 * @author    lifenglin <lifenglin1987@gmail.com>
 * @copyright 2013 lifenglin1987@gmail.com
 * @license   https://github.com/lifenglin/rdp BSD Licence
 * @version   Release: <package_version>
 * @link      https://github.com/lifenglin/rdp
 */
class Rdp_Entity_Str extends Rdp_Entity_Abstract
{
    protected $strType = 'str';
    protected $intMaxLength = 1024;

    protected function input($strValue)
    {
        if ($this->intMaxLength < strlen($strValue)) {
            return false;
        }
        return $strValue;
    }

    protected function output($strValue)
    {
        return strval($strValue);
    }
}
