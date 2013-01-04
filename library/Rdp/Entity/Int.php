<?php
class Rdp_Entity_Int extends Rdp_Entity_Abstract
{
    protected $strType = 'int';

    protected function input($strValue)
    {
        if (!is_int($strValue) ? (ctype_digit($strValue)) : true) {
            return $strValue;
        } else {
            return false;
        }
    }

    protected function output($strValue)
    {
        return intval($strValue);
    }
}
