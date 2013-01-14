<?php
/**
 * Rdp_Entity
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
 * Rdp_Entity
 *
 * @category  PHP
 * @package   Rdp
 * @author    lifenglin <lifenglin1987@gmail.com>
 * @copyright 2013 lifenglin1987@gmail.com
 * @license   https://github.com/lifenglin/rdp BSD Licence
 * @version   Release: <package_version>
 * @link      https://github.com/lifenglin/rdp
 */
class Rdp_Entity extends Rdp_Core
{
    static public function getEntity($strType, $strValue = NULL)
    {
        $intPos = strpos($strType, '_');
        $strNamespace = substr($strType, 0, $intPos);
        if (strlen($strNamespace) && in_array($strNamespace, Yaf_Registry::get('app_namespace'))) {
            $strClassName = $strType;
            /*
            $arrType = explode('_', $strType);
            foreach ($arrType as $strVal) {
                $strClassName .= '_' . ucwords($strVal);
            }
            */
        } else {
            $strType = ucwords($strType);
            $strClassName = "Rdp_Entity_{$strType}";
        }
        $objEntity = new $strClassName($strValue);
        return $objEntity;
    }
}
