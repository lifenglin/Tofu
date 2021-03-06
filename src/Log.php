<?php
class Tofu_Log extends Tofu_Core
{
    protected static function buildBackstrace($arrBacktrace)
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
            $strArgs = str_replace("\n", '', implode(', ', $arrArgs));
            $strBacktrace .= sprintf("#%s %s(%s): %s(%s)\n", $intNum++, $arrItem['file'], $arrItem['line'], $arrItem['function'], $strArgs);
        }
        return trim($strBacktrace);
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
        //日志写到php系统日志中
        error_log("PHP {$strErrorType}$strLog");
        //如果打开了错误报告，打印出日志
        if (ini_get("error_reporting")) {
            $objRequest = Yaf_Dispatcher::getInstance()->getRequest();
            $strPrintLog = sprintf("\n<b>%s</b>:  %s in <b>%s</b> on line <b>%s</b>\n%s\n", $strErrorType, $strErrorMessage, $strErrorFile, $intErrorLine, $strBacktrace);
            if (!$objRequest->isCli()) {
                $strPrintLog = str_replace("\n", "</br>", $strPrintLog);
            }   
            printf($strPrintLog);
        }
        return true;
    }

    public static function exceptionHandler(exception $objException)
    {
        $strBacktrace = self::buildBackstrace($objException->getTrace());
        $strFile = $objException->getFile();
        $strMessage = $objException->getMessage();
        $strLine = $objException->getLine();
        $strLog = sprintf("Exception: %s in %s on line %s\n%s", $strFile, $strMessage, $strLine, $strBacktrace);
        error_log($strLog, 3, APP_EXCEPTION_LOG_PATH);
        if (ini_get("error_reporting")) {
            echo $strLog;
        }
    }
    public static function shutdownErrorHandler()
    {
        if (ini_get("error_reporting")) {
            var_dump(error_get_last());
        }
    }
}
