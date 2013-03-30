<?php
/**
 * Tofu_Init
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
 * Tofu_Init 
 *
 * @category  PHP
 * @package   Tofu
 * @author    lifenglin <lifenglin1987@gmail.com>
 * @copyright 2013 lifenglin1987@gmail.com
 * @license   https://github.com/lifenglin/Tofu BSD Licence
 * @version   Release: <package_version>
 * @link      https://github.com/lifenglin/Tofu
 */
class Tofu_Init
{
    static private $_isInit = false;

    public static function init($app_name = null)
    {
        if(self::$_isInit) {
            return false;
        }
        self::$_isInit = true;

        // 初始化环境
        self::initEnv();

        //初始化错误捕捉
        self::initHandler();

        // 初始化Ap框架
        self::initYaf();


        return Yaf_Application::app();
    }

    private static function initEnv()
    {
        require(ENV_PHP_LIBS_PATH . "/Tofu/Core.php");
        require(ENV_PHP_LIBS_PATH . "/Tofu/Env.php");
        Tofu_Env::getInstance();
        return true;
    }

    // 初始化Ap
    private static function initYaf()
    {
        $app = new Yaf_Application(APP_CONF_PATH . "/application.ini");
        return true;
    }

    private static function initHandler()
    {
        require(ENV_PHP_LIBS_PATH . "/Tofu/Log.php");
        set_error_handler(array('Tofu_Log', 'errorHandler'));
        set_exception_handler(array('Tofu_Log', 'exceptionHandler'));
        register_shutdown_function(array('Tofu_Log', 'shutdownErrorHandler'));
    }
}
