<?php

class ExcelToArrary
{
    public function __construct()
    {
        Vendor("Excel.PHPExcel"); //引入phpexcel类(注意你自己的路径)
        Vendor("Excel.PHPExcel.IOFactory");
    }

    public function read($filename, $encode, $file_type)
    {
        vendor('PHPExcel_1_7_8.Classes.PHPExcel');
        vendor('PHPExcel_1_7_8.Classes.PHPExcel.IOFactory');
        vendor('PHPExcel_1_7_8.Classes.PHPExcel.Worksheet');
        $FileLast = explode(".", $fileURL);
        //判断文件类型，如果不是"xls"或者"xlsx"，则退出
        if (strtolower($file_type) == 'xls') {
            $inputFileType = 'Excel5';
        } elseif (strtolower($file_type) == "xlsx") {
            $inputFileType = 'Excel2007';
        }
        //设置php服务器可用内存，上传较大文件时可能会用到
        ini_set('memory_limit', '1024M');
        //创建导入对象
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($filename);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $excelData = array();
        for ($row = 1; $row <= $highestRow; $row++) {
            for ($col = 0; $col < $highestColumnIndex; $col++) {
                $excelData[$row][] = (string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            }
        }
        array_shift($excelData);
        return $excelData;
    }
}