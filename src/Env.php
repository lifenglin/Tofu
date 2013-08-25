<?php
/**
 * Tofu_Env
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
 * Tofu_Env
 *
 * @category  PHP
 * @package   Tofu
 * @author    lifenglin <lifenglin1987@gmail.com>
 * @copyright 2013 lifenglin1987@gmail.com
 * @license   https://github.com/lifenglin/Tofu BSD Licence
 * @version   Release: <package_version>
 * @link      https://github.com/lifenglin/Tofu
 */
class Tofu_Env extends Tofu_Core
{
    public function construct()
    {
        $this->_initBasicEnv();
        $this->_initAppEnv();
    }
    
    private function _initBasicEnv()
    {
        define("ENV_LOG_PATH", ENV_ROOT . "/log");
    }

    private function _initAppEnv()
    {
        define("APP_NAME", $this->_getAppName());
        define("APP_LOG_PATH", ENV_LOG_PATH . '/' . APP_NAME);
        define('APP_ERROR_LOG_PATH', APP_LOG_PATH . '.error.log');
        define('APP_WARNING_LOG_PATH',  APP_LOG_PATH . '.warning.log');
        define('APP_NOTICE_LOG_PATH', APP_LOG_PATH . '.notice.log');
        define('APP_UNKNOWN_LOG_PATH', APP_LOG_PATH . '.unknown.log');
        define('APP_EXCEPTION_LOG_PATH', APP_LOG_PATH . '.exception.log');

        define('APP_USER_ERROR_LOG_PATH', APP_LOG_PATH . '.user.error.log');
        define('APP_USER_WARNING_LOG_PATH',  APP_LOG_PATH . '.user.warning.log');
        define('APP_USER_NOTICE_LOG_PATH', APP_LOG_PATH . '.user.notice.log');

        define('APP_MODULES_PATH', APP_PATH . '/application/modules');
        define('APP_CONF_PATH', APP_PATH . '/conf');
    }

    private static function _getAppName()
    {
        $pos = strrpos(rtrim(APP_PATH, '/'), '/');
        return trim(substr(APP_PATH, $pos), '/');
    }
}
