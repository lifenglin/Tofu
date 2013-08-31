<?php
class Tofu_Error_CommonConf extends Tofu_Conf
{
    protected function getConfPath()
    {
        return dirname(__FILE__) . '/error.ini';
    }
}
