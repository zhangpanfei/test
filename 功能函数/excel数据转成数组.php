<?php
	/*$filename='a.xls';
	require_once './Classes/PHPExcel.php';     //修改为自己的目录
	echo '<p>TEST PHPExcel 1.8.0: read xlsx file</p>';
	$objReader = PHPExcel_IOFactory::createReaderForFile($filename);
	$objPHPExcel = $objReader->load($filename);
	$objPHPExcel->setActiveSheetIndex(1);
	$date = $objPHPExcel->getActiveSheet()->getCell('A')->getValue();
	print_r($date);*/
	//print_r($objWorksheet);

/* 将excel转换为数组 by aibhsc
* */
	const ROOT_PATH='./Classes';
	require(ROOT_PATH . '/PHPExcel.php');//引入PHP EXCEL类
	function format_excel2array($filePath='',$sheet=0){
	        if(empty($filePath) or !file_exists($filePath)){die('file not exists');}
	        $PHPReader = new PHPExcel_Reader_Excel2007();        //建立reader对象
	        if(!$PHPReader->canRead($filePath)){
	                $PHPReader = new PHPExcel_Reader_Excel5();
	                if(!$PHPReader->canRead($filePath)){
	                        echo 'no Excel';
	                        return ;
	                }
	        }
	        $PHPExcel = $PHPReader->load($filePath);        //建立excel对象
	        $currentSheet = $PHPExcel->getSheet($sheet);        //**读取excel文件中的指定工作表*/
	        $allColumn = $currentSheet->getHighestColumn();        //**取得最大的列号*/
	        $allRow = $currentSheet->getHighestRow();        //**取得一共有多少行*/
	        $data = array();
	        for($rowIndex=1;$rowIndex<=$allRow;$rowIndex++){        //循环读取每个单元格的内容。注意行从1开始，列从A开始
	                for($colIndex='A';$colIndex<=$allColumn;$colIndex++){
	                        $addr = $colIndex.$rowIndex;
	                        $cell = $currentSheet->getCell($addr)->getValue();
	                        if($cell instanceof PHPExcel_RichText){ //富文本转换字符串
	                                $cell = $cell->__toString();
	                        }
	                        $data[$rowIndex][$colIndex] = $cell;
	                }
	        }
	        return $data;
	}
	$filePath='./a.xls';
	print_r(format_excel2array($filePath));
	 
?>