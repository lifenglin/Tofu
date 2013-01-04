<?php
class Rdp_Core
{
    static protected $objSelf;

    public function __construct()
    {
        self::$objSelf = $this;
        $arrArgs = func_get_args();
        $strClassName = get_called_class();
        if (method_exists(self::$objSelf, 'construct')) {
            $objMethod = new ReflectionMethod($strClassName, 'construct');
            $objMethod->invokeArgs(self::$objSelf, $arrArgs);
        }
    }
    public function getInstance()
    {
        if (!is_object(self::$objSelf)) {
            $arrArgs = func_get_args();
            $strClassName = get_called_class();
            $objRc = new ReflectionClass($strClassName);
            $objRc->newInstanceArgs($arrArgs);
        }
        return self::$objSelf;
    }
}
