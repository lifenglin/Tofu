<?php
/**
 * Tofu_Entity
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
 * Tofu_Entity
 *
 * @category  PHP
 * @package   Tofu
 * @author    lifenglin <lifenglin1987@gmail.com>
 * @copyright 2013 lifenglin1987@gmail.com
 * @license   https://github.com/lifenglin/Tofu BSD Licence
 * @version   Release: <package_version>
 * @link      https://github.com/lifenglin/Tofu
 */
class Tofu_Params_Entity extends Tofu_Core
{
    /**
     * get a Tofu_Entity object.
     *
     * @param str $strType  实体类型
     * @param str $strValue 实体初始化放入的值
     *
     * @return obj $objEntity 实体对象
     */
    static public function getEntity($strType, $strValue = null, $intLength = 1024, $strExtra = null)
    {
        $intPos       = strpos($strType, '_');
        $strNamespace = substr($strType, 0, $intPos);
        if (strlen($strNamespace) && in_array($strNamespace, 
                    Yaf_Registry::get('app_namespace'))) {
            $strClassName = $strType;
        } else {
            $strType      = ucwords($strType);
            $strClassName = "Tofu_Params_Entity_{$strType}";
        }
        $objEntity = new $strClassName($strValue, $intLength, $strExtra);
        return $objEntity;
    }
}
