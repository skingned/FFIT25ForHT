
<!DOCTYPE html>
<html>
<head>
</head>
<body>

<form  method="post" enctype="multipart/form-data">
upload POF Excel file <input type="file" name="fileToUpload" id="fileToUpload"  accept=".xlsx">
<br>
<hr>
<input type="submit" value="Upload" name="submit">

</form>
</body>
</html>
<?php
set_time_limit(900);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

if (!empty($_FILES)){ //上傳後開始動作	
	require_once "inc.php";
	//upload files
	echo date('H:i:s') . " Load from POF Excel2007 file<br>";
	$objPHPExcel = PHPExcel_IOFactory::load( $_FILES["fileToUpload"]["tmp_name"]);//讀取
	
	//產生輸出檔案
	$objPHPExcelW = new PHPExcel();
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcelW);
	$sheetNames = $objPHPExcel->getSheetNames();//讀取sheet	
	$myrow=3;//控制全頁面的列	
		
	$ncol=array('項次','分類');//大表頭陣列
	foreach ($sheetNames as $k =>$sheet){
		if($sheet !="Cross-References" and $sheet !="PDN item already disapear"){//前二個不處理	
		//echo "$sheet<br>";
		$objPHPExcel->setActiveSheetIndex($k);		
		$sheetData = $objPHPExcel->getActiveSheet($k)->toArray(null,true,true,true);
		$sheetData[5]=array_filter($sheetData[5]);//過濾空白的欄位
		/*if ($sheet=="MOSFET - N-Channel"){
			print_r ($sheetData[5]);
		}*/
		foreach($sheetData[5] as $ck=>$cv){				
			$cv=trim($cv);			
			if(!in_array($cv,$ncol)){
				array_push($ncol,$cv);
			}					
		}		
		}
	}
	
	//轉換成文字
	//寫入位址	
	foreach ($ncol as $c=>$v){		//表頭的處理
		$c2=$c;
		$cc=intval($c2%26)+65;//A /26進位 個位數
		$a2=floor($c2/26)+64;//進位數

		$poc="";
		if ($a2 > 64){//2位數		
			$txtcol[chr($a2).chr($cc)]=$v;
			$poc=chr($a2).chr($cc);
		}else{//1位數			
			$txtcol[chr($cc)]=$v;	
			$poc=chr($cc);
		}	
		$objPHPExcelW->getActiveSheet()->setCellValue($poc.'2',$v);	//輸出表頭
	}

	$objPHPExcelW->getActiveSheet()->getStyle("A1:".$poc."2")->getFont()->setBold(true);
		//设置sheet的name
	$objPHPExcelW->getActiveSheet()->setTitle('POF');
	$objPHPExcelW->getActiveSheet()->setCellValue('A1','POF big table');
	$objPHPExcelW->getActiveSheet()->mergeCells('A1:D1');
	$objPHPExcelW->getActiveSheet()->getStyle('A1:D1')->getFont()->setSize(16);
	
	$objPHPExcelW->getActiveSheet()->setCellValue($poc.'1','Date:'.date('Y-m-d H:i:s'));
	//$ncol;//陣列是數字
	//$txtcol;//陣列是文字
	
	
	foreach ($sheetNames as $k =>$sheet){
		if($sheet !="Cross-References" and $sheet !="PDN item already disapear"){//前二個不處理			
			$objPHPExcel->setActiveSheetIndex($k);
			$sheetData = $objPHPExcel->getActiveSheet($k)->toArray(null,true,true,true);			
			foreach ($sheetData as $rk =>$rv){//row
				if ($rk==5){
					$tcol=array();//表頭 查索引用
						foreach($rv as $ck=>$cv){						
								$tcol[$ck]=trim($cv);										
						}						
				}else if ($rk >5){					
					if ($rv["A"] != "" && trim($tcol["A"]=="Part Number")){//NO part number 這是空行
						$objPHPExcelW->getActiveSheet()->setCellValue('A'.$myrow,$myrow-2);//筆數序號
						$objPHPExcelW->getActiveSheet()->setCellValue('B'.$myrow,$sheet);//資料表名稱
						foreach($rv as $ck=>$cv){ //col							
							$pos=array_search(trim($tcol[$ck]),$txtcol); //傳回key	
							
							if ($pos==""){
							//	echo "ck=$ck $tcol[$ck] pos='$pos  $myrow',val=$cv<br>";
							}else{					
								$objPHPExcelW->getActiveSheet()->setCellValue($pos.$myrow,$cv);//資料表名稱								
							}
						}
						$myrow++;//下一列	
					}//跳過					
				}	
			}
			echo "<hr>$sheet 已處理!!";
		}else{
			echo "<hr> $sheet 不處理 ";//"</table>";
		}		
	}	


	$objWriter->save("Big-".$_FILES["fileToUpload"]["name"]);//存檔	
	// Echo memory peak usage
	echo date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB<br>";
	// Echo done
	echo date('H:i:s') . " Done writing files.<br>";
	echo '<a href="http://10.0.1.60:81/POF/Big-'.$_FILES["fileToUpload"]["name"].'"'." >下載</a>";
}else{
	echo "upload your file!!";
}