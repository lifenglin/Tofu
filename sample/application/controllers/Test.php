<?php
class TestController extends Rdp_Controller_Abstract
{
    protected $strResonseFormat = array(
        'index' => 'json',
    );
    protected $arrPageServiceParamsConfigure = array(
        'index' => array('para' => array('type' => 'int', 'default' => 0)),
    );
    protected $arrPageServiceParams = array();
    protected $arrPageServiceReturnConfigure = array(
        'index' => array('hehe' => array('type' => 'int', 'default' => 0)),
    );
    protected $arrPageServiceReturn = array();
    public function indexAction()
    {
        $this->_initResponseFormat();
        $this->_initPageServiceparams();
        var_dump($this->arrPageServiceParams);
        //pageService($arrPageServiceParams);
        $this->end();
    }
}
