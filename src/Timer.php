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
     * record begin time
     *
     * @see process()
     */
    static public function begin($strName = 'default')
    {
        return self::$arrData[$strName]['begin'] = self::$arrData[$strName]['end'] = microtime(true);
    }

    /**
     * record end time
     *
     * @see process()
     */
    static public function end($strName = 'default')
    {
        return self::$arrData[$strName]['end'] = microtime(true);
    }

    /**
     * count time
     *
     * @see process()
     */
    static public function count($strName = 'default')
    {
        return round((self::$arrData[$strName]['end'] - self::$arrData[$strName]['begin']) * 1000);
    }

    /**
     * count all time
     *
     * @see process()
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
