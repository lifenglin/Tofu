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
    static protected $objSelf;

    /**
     * Constructs a Tofu_Core object.
     *
     * @see process()
     */
    public function __construct()
    {
        self::$objSelf = $this;
        $arrArgs       = func_get_args();
        $strClassName  = get_called_class();
        if (method_exists(self::$objSelf, 'construct')) {
            $objMethod = new ReflectionMethod($strClassName, 'construct');
            $objMethod->invokeArgs(self::$objSelf, $arrArgs);
        }
    }
    /**
     * get a Tofu_Core instance.
     *
     * @see process()
     * @return object
     */
    public function getInstance()
    {
        if (!is_object(self::$objSelf)) {
            $arrArgs       = func_get_args();
            $strClassName  = get_called_class();
            $objReflection = new ReflectionClass($strClassName);
            $objReflection->newInstanceArgs($arrArgs);
        }
        return self::$objSelf;
    }
}
