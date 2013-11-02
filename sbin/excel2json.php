<?php
require('Excel2Conf.php');
if (!isset($argv[1]) || !is_readable($argv[1])) {
        die("请检查xlsx文件地址!\n");
}
$strFilepath = $argv[1];
$strFilename = basename($strFilepath, '.xlsx');
$strOutputFilepath = dirname($argv[1]) . '/output/';
if (isset($argv[2])) {
        $strOutputFilepath = $argv[2] . '/';
}
if (!is_writeable($strOutputFilepath)) {
        mkdir($strOutputFilepath);
}
$arrExcel = Excel2Conf::excel2array($strFilepath);
file_put_contents($strOutputFilepath . $strFilename . '.json', json_encode($arrExcel));
