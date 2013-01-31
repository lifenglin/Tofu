#!/usr/bin/php
<?php
require('PHPExcel.php');
if (!isset($argv[1]) || !is_readable($argv[1])) {
    die("请检查xlsx文件地址!\n");
}
$strOutputFilepath = dirname($argv[1]) . '/output/';
if (isset($argv[2])) {
    $strOutputFilepath = $argv[2] . '/';
}
if (!is_writeable($strOutputFilepath)) {
    mkdir($strOutputFilepath);
}
$strFilepath = $argv[1];
$arrInterfaceConfig = array('module', 'controller', 'action', 'method', 'output_format', 'inoutput', 'param_name', 'is_required', 'alow_null');
$arrParamsDictionary = array('param_name', 'param_chinese_name', 'param_type', 'default', 'length', 'extra', 'remarks');
$arrWorksheets = array('interface_config' => $arrInterfaceConfig, 'params_dictionary' => $arrParamsDictionary);
$arrConf = excel2conf($strFilepath, $arrWorksheets);
foreach ($arrConf as $strFileName => $strContents) {
    file_put_contents($strOutputFilepath . $strFileName, $strContents);
}

function excel2conf($strFilepath, $arrWorksheets)
{
    $arrExcel = excel2array($strFilepath);
    compareExcelAndWorksheets($arrExcel, $arrWorksheets);
    return array2conf($arrExcel);
}
function array2conf($arrExcel)
{
    $arrConf = array();
    foreach ($arrExcel as $strFilename => $arrExcelConfig) {
        $objFunction = new ReflectionFunction('build_' . $strFilename);
        $arrConf[$strFilename] = $objFunction->invoke($arrExcelConfig);
    }
    return $arrConf;
}
function build_params_dictionary($arrExcelConfig)
{
    $strConfigContents  = '';
    foreach ($arrExcelConfig as $arrConfig) {
        $strParamName        = $arrConfig['param_name'];
        $strParamChineseName = $arrConfig['param_chinese_name'];
        $strParamType        = $arrConfig['param_type'];
        $mixDefault = $arrConfig['default'];
        $intLength = $arrConfig['length'];
        $strExtra = $arrConfig['extra'];
        $strRemarks = $arrConfig['remarks'];
        $strTag = sprintf('[%s]', $strParamName);
        $arrConfigContents[$strTag] = array(
                'param_chinese_name' => $strParamChineseName,
                'param_type' => $strParamType,
                'default' => $mixDefault,
                'length' => $intLength,
                'extra' => $strExtra,
                'remarks' => $strRemarks,
        );
    }
    return arrContents2strContens($arrConfigContents);
}
function build_interface_config($arrExcelConfig)
{
    $strConfigContents  = '';
    $strModule          = NULL;
    $strController      = NULL;
    $strAction          = NULL;
    $strLastTag         = NULL;

    foreach ($arrExcelConfig as $arrConfig) {
        if ($arrConfig['module'] !== NULL) {
            $strModule = $arrConfig['module'];
        }
        if ($arrConfig['controller'] !== NULL) {
            $strController = $arrConfig['controller'];
        }
        if ($arrConfig['action'] !== NULL) {
            $strAction = $arrConfig['action'];
        }
        if (empty($strModule) || empty($strController) || empty($strAction)) {
            die('tag 有问题');
        }
        $strTag = sprintf("[%s.%s.%s]", $strModule, $strController, $strAction);
        if ($strTag !== $strLastTag) {
            $strInoutput = NULL;
            $strLastTag = $strTag;
        }
        if (NULL != $arrConfig['method']) {
            $arrConfigContents[$strTag]['method'] = $arrConfig['method'];
        }
        if (NULL != $arrConfig['output_format']) {
            $arrConfigContents[$strTag]['output_format'] = $arrConfig['output_format'];
        }
        if (NULL != $arrConfig['inoutput']) {
            $strInoutput = $arrConfig['inoutput'];
        }
        if (empty($strInoutput)) {
            die('输入输出有问题');
        }
        $bolIsRequired = $arrConfig['is_required'] === 'Yes' ? true : false;
        $bolAlowNull = $arrConfig['alow_null'] === 'Yes' ? true : false;
        $arrConfigContents[$strTag][$strInoutput][] = array(
                'param_name' => $arrConfig['param_name'],
                'is_required' => $bolIsRequired,
                'alow_null' => $bolAlowNull,
                );
        return arrContents2strContens($arrConfigContents);
    }
    
}
function arrContents2strContens($arrConfigContents)
{
    $strConfigContents = '';
    foreach ($arrConfigContents as $strTag => $arrContent) {
        $strConfigContents .= sprintf("%s\n", $strTag);
        foreach ($arrContent as $strConfigName => $mixConfig) {
            if (is_array($mixConfig)) {
                $strContents = serialize($mixConfig);
            } else {
                $strContents = $mixConfig;
            }
            $strConfigContents .= sprintf("%s = '%s';\n", $strConfigName, $strContents);
        }
    }
    return $strConfigContents;
}
function compareExcelAndWorksheets($arrExcel, $arrWorksheets)
{
    $arrWorksheetsDiff = array_diff(array_keys($arrExcel), array_keys($arrWorksheets));
    if (!empty($arrWorksheetDiff)) {
        die('工作簿有问题');
    }
    foreach ($arrWorksheets as $strWorksheet => $arrWorksheet) {
        $intRandKey = array_rand($arrExcel[$strWorksheet]);
        $arrWorksheetDiff = array_diff(array_values($arrWorksheet), array_keys($arrExcel[$strWorksheet][$intRandKey]));
        if (!empty($arrWorksheetDiff)) {
            die('工作簿内列有问题');
        }
    }
}
function excel2array($strFilepath)
{
    $arrExcel = array();
    //创建一个2007的读取对象
    $objReader = PHPExcel_IOFactory::createReader('Excel2007'); 
    //读取一个xlsx文件
    $objPHPExcel = $objReader->load($strFilepath);
    //遍历工作表
    foreach ($objPHPExcel->getWorksheetIterator() as $objWorksheet) {
        $strTitle = $objWorksheet->getTitle();
        $arrExcel[$strTitle] = array();
        //遍历行
        foreach ($objWorksheet->getRowIterator() as $objRow) {
            //得到所有列
            $objCellIterator = $objRow->getCellIterator();
            //Loop all cells, even if it is not set
            $objCellIterator->setIterateOnlyExistingCells(false);
            //遍历列
            foreach ($objCellIterator as $objCell) {
                preg_match_all('/[a-zA-Z]+/', $objCell->getCoordinate(), $arrMatches);
                $strOrdinate = $arrMatches[0][0];
                if (1 === $objRow->getRowIndex()) {
                    $arrColumnName[$strOrdinate] = $objCell->getCalculatedValue();
                } else {
                    $arrExcel[$strTitle][$objRow->getRowIndex()][$arrColumnName[$strOrdinate]] = $objCell->getCalculatedValue();
                }
            }
        }
    }
    return $arrExcel;
}
exit;
