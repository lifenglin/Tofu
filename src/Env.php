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
        $strEnv = Yaf_Application::app()->environ();
        if ('product' === $strEnv) {
            ini_set('display_errors', 0);
        } else {
            ini_set('display_errors', 1);
        }
    }

    private function _initAppEnv()
    {
        define("APP_NAME", $this->_getAppName());
        define('APP_CONF_PATH', APP_PATH . '/conf');
    }

    private static function _getAppName()
    {
        $pos = strrpos(rtrim(APP_PATH, '/'), '/');
        return trim(substr(APP_PATH, $pos), '/');
    }
}
