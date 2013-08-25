<?php
/**
 * Tofu_Core 
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
 * Tofu_Core 
 *
 * @category  PHP
 * @package   Tofu
 * @author    lifenglin <lifenglin1987@gmail.com>
 * @copyright 2013 lifenglin1987@gmail.com
 * @license   https://github.com/lifenglin/Tofu BSD Licence
 * @version   Release: <package_version>
 * @link      https://github.com/lifenglin/Tofu
 */
class Tofu_Core
{
    static protected $arrSelf = array();

    /**
     * Constructs a Tofu_Core object.
     *
     * @see process()
     */
    public function __construct()
    {
        $strClassName  = get_called_class();
        self::$arrSelf[$strClassName] = $this;
        $arrArgs       = func_get_args();
        $strClassName  = get_called_class();
        if (method_exists(self::$arrSelf[$strClassName], 'construct')) {
            $objMethod = new ReflectionMethod($strClassName, 'construct');
            $objMethod->invokeArgs(self::$arrSelf[$strClassName], $arrArgs);
        }
    }

    /**
     * get a Tofu_Core instance.
     *
     * @see process()
     * @return object
     */
    public static function getInstance()
    {
        $strClassName  = get_called_class();
        if (!array_key_exists($strClassName, self::$arrSelf) || !is_object(self::$arrSelf[$strClassName])) {
            $arrArgs       = func_get_args();
            $objReflection = new ReflectionClass($strClassName);
            self::$arrSelf[$strClassName] = $objReflection->newInstanceArgs($arrArgs);
        }
        return self::$arrSelf[$strClassName];
    }
}
