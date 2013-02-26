<?php
class ErrorController extends Yaf_Controller_Abstract
{
    public function errorAction()
    {
        $exception = $this->getRequest()->getException();
        try {
            throw $exception;
        } catch (Yaf_Exception_LoadFailed $e) {
            //加载失败
        } catch (Yaf_Exception $e) {
            //其他错误
            //页面输出
            $this->getView()->assign("code", $exception->getCode());
            $this->getView()->assign("message", $exception->getMessage());
            //json输出
        }
    }
}
