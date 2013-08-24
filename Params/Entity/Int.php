<?php
/**
 * Tofu_Entity_Int 
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
 * Tofu_Entity_Int 
 *
 * @category  PHP
 * @package   Tofu
 * @author    lifenglin <lifenglin1987@gmail.com>
 * @copyright 2013 lifenglin1987@gmail.com
 * @license   https://github.com/lifenglin/Tofu BSD Licence
 * @version   Release: <package_version>
 * @link      https://github.com/lifenglin/Tofu
 */
class Tofu_Params_Entity_Int extends Tofu_Params_Entity_Abstract
{
    protected $strType = 'int';

    /**
     * input 
     * 
     * @param int $intValue 实体值
     *
     * @access protected
     * @return int intValue
     */
    protected function input($intValue)
    {
        if (!is_int($intValue) ? (ctype_digit($intValue)) : true) {
            return $intValue;
        } else {
            return false;
        }
    }

    /**
     * output 
     * 
     * @param int $intValue 实体值
     *
     * @access protected
     * @return int intValue
     */
    protected function output($intValue)
    {
        return intval($intValue);
    }
}
