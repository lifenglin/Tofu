<?php
/**
 * Tofu_Log 
 * 
 *    define('APP_ERROR_LOG_PATH', '/tmp/error');
 *    define('APP_WARNING_LOG_PATH', '/tmp/warning');
 *    define('APP_NOTICE_LOG_PATH', '/tmp/notice');
 *    define('APP_UNKNOWN_LOG_PATH', '/tmp/unknown');
 *    define('APP_EXCEPTION_LOG_PATH', '/tmp/exception');
 *    set_error_handler(array('Tofu_Log', 'errorHandler'));
 *    set_exception_handler(array('Tofu_Log', 'exceptionHandler'));
 *    register_shutdown_function(array('Tofu_Log', 'shutdownErrorHandler'));
 *    warning('hehe');
 *    function warning ($a){
 *        trigger_error("Cannot divide by zero", E_USER_WARNING);
 *        throw new exception('hehe');
 *    }
 * @package 
 * @version $id$
 * @copyright 1997-2005 The PHP Group
 * @author Tobias Schlitt <toby@php.net> 
 * @license PHP Version 3.0 {@link http://www.php.net/license/3_0.txt}
 */
class Tofu_Log extends Tofu_Core
{
    public static function exceptionHandler(exception $objException)
    {
        $strBacktrace = self::buildBackstrace($objException->getTrace());
        $strLog = sprintf("Exception: %s in %s on line %s\n%s", $objException->getFile(), $objException->getMessage(), $objException->getLine(), $strBacktrace);
        error_log($strLog, 3, APP_EXCEPTION_LOG_PATH);
        if (ini_get("error_reporting")) {
            echo $strLog;
        }
    }
    public static function errorHandler($constErrno, $strErrorMessage, $strErrorFile, $intErrorLine)
    {
        $arrBacktrace = debug_backtrace();
        $strBacktrace = self::buildBackstrace($arrBacktrace);
        switch ($constErrno) {
            case E_USER_ERROR:
                $strErrorType = 'Fatal error';
                break;
            case E_USER_WARNING:
                $strErrorType = 'Warning';
                break;
            case E_USER_NOTICE:
                $strErrorType = 'Notice';
                break;
            case E_ERROR:
                $strErrorType = 'Fatal error';
                break;
            case E_WARNING:
                $strErrorType = 'Warning';
                break;
            case E_NOTICE:
                $strErrorType = 'Notice';
                break;
            default:
                $strErrorType = 'Unknown';
                break;
        }
        $strLog = sprintf(": %s in %s on line %s\n%s", $strErrorMessage, $strErrorFile, $intErrorLine, $strBacktrace);
        error_log($strLog);
        if (ini_get("error_reporting")) {
            $strBacktrace = str_replace("\n", "</br>", $strBacktrace);
            $strPrintLog = sprintf("<br /><b>%s</b>  %s in <b>%s</b> on line <b>%s</b></br>%s</br>", $strErrorType, $strErrorMessage, $strErrorFile, $intErrorLine, $strBacktrace);
            printf($strPrintLog);
        }
        return true;
    }
    public static function shutdownErrorHandler()
    {
        if (ini_get("error_reporting")) {
            var_dump(error_get_last());
        }
    }
    private static function buildBackstrace($arrBacktrace)
    {
        $strBacktrace = '';
        if (!is_array($arrBacktrace) || 0 === count($arrBacktrace)) {
            return $strBacktrace;
        }
        $intNum = 0;
        foreach ($arrBacktrace as $arrItem) {
            if (empty($arrItem['file']) || empty($arrItem['line'])) {
                continue;
            }
            $arrArgs = array();
            foreach ($arrItem['args'] as $mixArg) {
                $arrArgs[] = str_replace("\n", '', var_export($mixArg, true));
            }
            $strBacktrace .= sprintf("#%s %s(%s): %s(%s)\n", $intNum++, $arrItem['file'], $arrItem['line'], $arrItem['function'], str_replace("\n", '', implode(', ', $arrArgs)));
        }
        return $strBacktrace;
    }
}
