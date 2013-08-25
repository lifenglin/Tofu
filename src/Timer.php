<?php
/**
 * Tofu_Timer
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
 * Tofu_Timer
 *
 * @category  PHP
 * @package   Tofu
 * @author    lifenglin <lifenglin1987@gmail.com>
 * @copyright 2013 lifenglin1987@gmail.com
 * @license   https://github.com/lifenglin/Tofu BSD Licence
 * @version   Release: <package_version>
 * @link      https://github.com/lifenglin/Tofu
 */
class Tofu_Timer extends Tofu_Core
{
    static protected $arrData = array();

    /**
     * @param string $strName
     * 记录某个行为的开始时间
     * @access public
     * @return float
     */
    static public function begin($strName = 'default')
    {
        return self::$arrData[$strName]['begin'] = self::$arrData[$strName]['end'] = microtime(true);
    }

    /**
     * @param string $strName
     * 记录某个行为的结束时间
     * @access public
     * @return float
     */
    static public function end($strName = 'default')
    {
        return self::$arrData[$strName]['end'] = microtime(true);
    }

    /**
     * @param string $strName
     * 计算某个行为的耗时
     * @access public
     * @return float
     */
    static public function count($strName = 'default')
    {
        return round((self::$arrData[$strName]['end'] - self::$arrData[$strName]['begin']) * 1000);
    }

    /**
     * @param string $strName
     * 计算全部行为的耗时
     * @access public
     * @return array
     */
    static public function countAll($strName = 'default')
    {
        $arrCount = array();
        $arrKeys = array_keys(self::$arrData);
        foreach ($arrKeys as $strName) {
            $arrCount[$strName] = self::count($strName);
        }
        return $arrCount;
    }
}
