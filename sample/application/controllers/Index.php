<?php
class IndexController extends Yaf_Controller_Abstract
{
    public function indexAction()
    {
        $request = $this->getRequest();
        var_dump($request);
        $this->getView()->assign("content", "Hello World");
    }
}
