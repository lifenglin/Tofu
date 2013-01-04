<?php
class Rdp_Entity_Str extends Rdp_Entity_Abstract
{
    protected $strType = 'str';
    protected $intMaxLength = 1024;

    protected function input($strValue)
    {
        if ($this->intMaxLength < strlen($strValue)) {
            return false;
        }
        return $strValue;
    }

    protected function output($strValue)
    {
        return strval($strValue);
    }
}
