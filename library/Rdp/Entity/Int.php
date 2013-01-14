<?php
/**
 * Rdp_Entity_Int 
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
 * Rdp_Entity_Int 
 *
 * @category  PHP
 * @package   Rdp
 * @author    lifenglin <lifenglin1987@gmail.com>
 * @copyright 2013 lifenglin1987@gmail.com
 * @license   https://github.com/lifenglin/rdp BSD Licence
 * @version   Release: <package_version>
 * @link      https://github.com/lifenglin/rdp
 */
class Rdp_Entity_Int extends Rdp_Entity_Abstract
{
    protected $strType = 'int';

    protected function input($strValue)
    {
        if (!is_int($strValue) ? (ctype_digit($strValue)) : true) {
            return $strValue;
        } else {
            return false;
        }
    }

    protected function output($strValue)
    {
        return intval($strValue);
    }
}
