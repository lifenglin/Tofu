<?php
class Tofu_Conf extends Tofu_Core
{
    protected $objConf = '';
    abstract protected function getConfPath();
    public function construct()
    {
        $this->objConf = new Yaf_Config_Ini($this->getConfPath());
    }
    public function __get($strFlag)
    {
        //todo:debug
        return $this->objConf->$strFlag;
    }
}
