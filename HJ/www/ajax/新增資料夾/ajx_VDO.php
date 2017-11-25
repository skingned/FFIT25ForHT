<?php

@session_start();
require_once ("../dist/js/xajax_core/xajax.inc.php");
$xajax = new xajax();
//$xajax->registerFunction("ResetPWD");
//$xajax->registerFunction("dacc");
//$xajax->registerFunction("cacc");

$ajxobj=$xajax->registerFunction("Scategory");

//$ajxobj->useSingleQuote();
//$ajxobj->addParameter(XAJAX_INPUT_VALUE,"org");
$xajax->processRequest();

function Scategory($formData,$type){//$type分類名   
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);
	//$objResponse->assign("msg","innerHTML",nl2br(print_r($formData, true)));
	//取值如何
	//值如何給?update 又如何區分
	if (!empty($formData['title'])){
		//有上傳圖片
		/*if (!empty($formData['picfile'])){
			$objResponse->append("msg","innerHTML",nl2br(print_r($_FILE, true)));
		}*/
	$val=$formData['title'];
	$query="insert into sys_category (form_type,title,val,sno,enable) values('$type','$val','$val','1','Y')";
	$res=MDB2_query($mdb2 ,$query);
	
	
	$objResponse->addAlert($type."-". $val. " 類別已新增");
	$_SESSION['Reload']=true; 
	}else{
		$objResponse->addAlert("標題未輸入");
	}
	
	$objResponse->script('location.reload();');
	return $objResponse;	
}/**/
?>