<?php
/**
 * Rdp_Core 
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
 * Rdp_Core 
 *
 * @category  PHP
 * @package   Rdp
 * @author    lifenglin <lifenglin1987@gmail.com>
 * @copyright 2013 lifenglin1987@gmail.com
 * @license   https://github.com/lifenglin/rdp BSD Licence
 * @version   Release: <package_version>
 * @link      https://github.com/lifenglin/rdp
 */
class Rdp_Core
{
    static protected $objSelf;

    /**
     * Constructs a Rdp_Core object.
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
     * get a Rdp_Core instance.
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
