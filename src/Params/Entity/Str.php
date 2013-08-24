<?php
/**
 * Tofu_Entity_Str
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
 * Tofu_Entity_Str
 *
 * @category  PHP
 * @package   Tofu
 * @author    lifenglin <lifenglin1987@gmail.com>
 * @copyright 2013 lifenglin1987@gmail.com
 * @license   https://github.com/lifenglin/Tofu BSD Licence
 * @version   Release: <package_version>
 * @link      https://github.com/lifenglin/Tofu
 */
class Tofu_Params_Entity_Str extends Tofu_Params_Entity_Abstract
{
    protected $strType = 'str';

    /**
     * input 
     * 
     * @param str $strValue 实体值
     *
     * @access protected
     * @return void
     */
    protected function input($strValue)
    {
        if ($this->intLength < mb_strlen($strValue)) {
            return false;
        }
        return $strValue;
    }

    /**
     * output 
     * 
     * @param str $strValue 实体值
     *
     * @access protected
     * @return void
     */
    protected function output($strValue)
    {
        return strval($strValue);
    }
}
