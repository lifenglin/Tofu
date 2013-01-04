<?php
class Rdp_Entity extends Rdp_Core
{
    static public function getEntity($strType, $strValue = NULL)
    {
        $intPos = strpos($strType, '_');
        $strNamespace = substr($strType, 0, $intPos);
        if (strlen($strNamespace) && in_array($strNamespace, Yaf_Registry::get('app_namespace'))) {
            $strClassName = $strType;
            /*
            $arrType = explode('_', $strType);
            foreach ($arrType as $strVal) {
                $strClassName .= '_' . ucwords($strVal);
            }
            */
        } else {
            $strType = ucwords($strType);
            $strClassName = "Rdp_Entity_{$strType}";
        }
        $objEntity = new $strClassName($strValue);
        return $objEntity;
    }
}
