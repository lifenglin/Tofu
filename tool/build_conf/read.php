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
$arrUiConfig = array('module', 'controller', 'action', 'method', 'response_format', 'req/res', 'param_name', 'is_required', 'allow_empty', 'default');
$arrParamsDictionary = array('param_name', 'param_chinese_name', 'param_type', 'length', 'extra', 'remarks');
$arrWorksheets = array('ui_config' => $arrUiConfig, 'params_dictionary' => $arrParamsDictionary);
$arrConf = excel2conf($strFilepath, $arrWorksheets);
foreach ($arrConf as $strFileName => $strContents) {
    file_put_contents($strOutputFilepath . $strFileName . '.ini', $strContents);
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
        if (empty($arrConfig['param_name'])) {
            continue;
        }
        $strParamName        = $arrConfig['param_name'];
        $strParamChineseName = $arrConfig['param_chinese_name'];
        $strParamType        = $arrConfig['param_type'];
        $intLength = $arrConfig['length'];
        $strRemarks = $arrConfig['remarks'];
        $strTag = sprintf('[%s]', $strParamName);
        if ('array' === $strParamType) {
            $strExtra = serialize(array_filter(explode("\n", $arrConfig['extra'])));
        } else {
            $strExtra = $arrConfig['extra'];
        }
        $arrConfigContents[$strTag] = array(
                'param_chinese_name' => $strParamChineseName,
                'param_type' => $strParamType,
                'length' => $intLength,
                'extra' => $strExtra,
                'remarks' => $strRemarks,
        );
    }
    return arrContents2strContens($arrConfigContents);
}
function build_ui_config($arrExcelConfig)
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
        if (NULL != $arrConfig['response_format']) {
            $arrConfigContents[$strTag]['response_format'] = $arrConfig['response_format'];
        }
        if (NULL != $arrConfig['req/res']) {
            $strReqRes = $arrConfig['req/res'];
        }
        if (empty($strReqRes)) {
            die('输入输出有问题');
        }
        $bolIsRequired = $arrConfig['is_required'] === 'Yes' ? true : false;
        $bolAllowEmpty = $arrConfig['allow_empty'] === 'Yes' ? true : false;
        $mixDefault    = $arrConfig['default'];
        if ($arrConfig['param_name'] === NULL) {
            continue;
        }
        $arrConfigContents[$strTag][$strReqRes][] = array(
                'param_name'  => $arrConfig['param_name'],
                'is_required' => $bolIsRequired,
                'allow_empty' => $bolAllowEmpty,
                'default'     => $mixDefault,
                );
    }
    return arrContents2strContens($arrConfigContents);
    
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
    $arrWorksheetsDiff1 = array_diff(array_keys($arrExcel), array_keys($arrWorksheets));
    $arrWorksheetsDiff2 = array_diff(array_keys($arrWorksheets), array_keys($arrExcel));
    if (!empty($arrWorksheetsDiff1) || !empty($arrWorksheetsDiff2)) {
        die('工作簿有问题');
    }
    foreach ($arrWorksheets as $strWorksheet => $arrWorksheet) {
        $intRandKey = array_rand($arrExcel[$strWorksheet]);
        $arrWorksheetDiff1 = array_diff(array_values($arrWorksheet), array_keys($arrExcel[$strWorksheet][$intRandKey]));
        $arrWorksheetDiff2 = array_diff(array_keys($arrExcel[$strWorksheet][$intRandKey]), array_values($arrWorksheet));
        if (!empty($arrWorksheetDiff1) || !empty($arrWorksheetDiff2)) {
            die('工作簿内列有问题');
        }
    }
}
function excel2array($strFilepath)
{
    $arrExcel = array();
    //创建一个2007的读取对象
    $objReader = PHPExcel_IOFactory::createReader('Excel5'); 
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
