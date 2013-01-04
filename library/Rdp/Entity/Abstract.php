<?php
class Rdp_Entity_Abstract extends Rdp_Core
{
    protected $strValue = null;
    protected $strType = null;

    //abstract protected function input($strValue);

    protected function output($strValue)
    {
        return $strValue;
    }

    public function construct($strValue)
    {
        $strValue !== NULL && $this->setValue($strValue);
    }

    public function setValue($strValue)
    {
        if (false !== $strValue = $this->input($strValue)) {
            $this->strValue = $strValue;
        } else {
            throw new Rdp_Exception();
        }
    }

    public function getValue()
    {
        return $this->output($this->strValue);
    }

    protected function setType($strType)
    {
        $this->strType = $strType;
    }

    public function getType()
    {
        return $this->strType;
    }
}
