<?php
class Tofu_Core
{
    static protected $_arrSelf = array();

    /**
     * Constructs a Tofu_Core object.
     */
    public function __construct()
    {
        $strClassName  = get_called_class();
        self::$_arrSelf[$strClassName] = $this;
        $arrArgs       = func_get_args();
        $strClassName  = get_called_class();
        if (method_exists(self::$_arrSelf[$strClassName], 'construct')) {
            $objMethod = new ReflectionMethod($strClassName, 'construct');
            $objMethod->invokeArgs(self::$_arrSelf[$strClassName], $arrArgs);
        }
    }

    /**
     * get a Tofu_Core instance.
     * @return object
     */
    public static function getInstance()
    {
        $strClassName  = get_called_class();
        if (!array_key_exists($strClassName, self::$_arrSelf)) {
            $arrArgs       = func_get_args();
            $objReflection = new ReflectionClass($strClassName);
            $objClass = $objReflection->newInstanceArgs($arrArgs);
            self::$_arrSelf[$strClassName] = $objClass;
        }
        return self::$_arrSelf[$strClassName];
    }
}
