<?php
/**
 * Rdp_Init
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
 * Rdp_Init 
 *
 * @category  PHP
 * @package   Rdp
 * @author    lifenglin <lifenglin1987@gmail.com>
 * @copyright 2013 lifenglin1987@gmail.com
 * @license   https://github.com/lifenglin/rdp BSD Licence
 * @version   Release: <package_version>
 * @link      https://github.com/lifenglin/rdp
 */
class Rdp_Init
{
    static private $_isInit = false;

    public static function init($app_name = null)
    {
        if(self::$_isInit) {
            return false;
        }
        self::$_isInit = true;

        // 初始化基础环境
        self::initBasicEnv();

        // 初始化App环境
        self::initAppEnv($app_name);

        // 初始化Ap框架
        self::initYaf();

        // 初始化日志库
        //self::initLog($app_name);

        // 执行产品线的auto_prepend
        self::doProductPrepend();

        return Yaf_Application::app();
    }

    private static function initBasicEnv()
    {
        // 页面启动时间(us)，PHP5.4可用$_SERVER['REQUEST_TIME']
        define('REQUEST_TIME_US', intval(microtime(true)*1000000));

        if (!defined('APP_PATH')) {
            die('未定义APP_PATH');
        }
        
        define('CONF_PATH', APP_PATH.'/conf');
        define('DATA_PATH', APP_PATH.'/data');
        define('LOG_PATH', APP_PATH.'/log');
        define('APPLICATION_PATH', APP_PATH.'/application');
        define('TPL_PATH', APP_PATH.'/views');
        //define('LIB_PATH', ROOT_PATH.'/php/phplib');
        define('PUB_ROOT', APP_PATH.'/public');
        //define('PHP_EXEC', BIN_PATH.'/php');

        return true;
    }

    private static function getAppName()
    {
        $pos = strrpos(rtrim(APP_PATH, '/'), '/');
        return trim(substr(APP_PATH, $pos), '/');
    }

    private static function initAppEnv($app_name)
    {
        // 检测当前App
        if($app_name != null || ($app_name = self::getAppName()) != null) {
            define('MAIN_APP', $app_name);
        } else {
            define('MAIN_APP', 'unknown-app');
        }
        // 设置当前App
        //require_once LIB_PATH.'/bd/AppEnv.php';
        //Bd_AppEnv::setCurrApp(MAIN_APP);

        return true;
    }

    /*
    // 初始化类自动加载
    private static function initAutoLoader()
    {
    $local_lib = Bd_AppEnv::getEnv('code').'/library';
    Ap_Loader::getInstance($local_lib, LIB_PATH);
    return true;
    }
     */

    // 初始化Ap
    private static function initYaf()
    {
        $app = new Yaf_Application(CONF_PATH."/application.ini");
        return true;
    }

    // 执行产品线的auto_prepend
    private static function doProductPrepend()
    {
        if(file_exists(APP_PATH."/auto_prepend.php"))
        {
            include_once APP_PATH."/auto_prepend.php";
        }
    }

    private static function initLog()
    {
        // 初始化日志库，仅为兼容老代码
        define('CLIENT_IP', Bd_Ip::getClientIp());

        //获取LogId
        if(!defined('LOG_ID'))
        {
            Bd_Log::genLogID();
        }
        //获取userip

        define('USER_IP', Bd_Ip::getUserIp());
        //获取上一个经过的服务器
        define('FRONTEND_IP', Bd_Ip::getFrontendIp());
        //获取Product
        if(getenv('HTTP_X_BD_PRODUCT'))
        {
            define('PRODUCT', trim(getenv('HTTP_X_BD_PRODUCT')));
        }
        else
        {
            define('PRODUCT', 'ORP');
        }
        //获取subsys
        if(getenv('HTTP_X_BD_SUBSYS'))
        {
            define('SUBSYS', trim(getenv('HTTP_X_BD_SUBSYS')));
        }
        else
        {
            define('SUBSYS', 'ORP');
        }
        define("MODULE", APP);
    }
}

