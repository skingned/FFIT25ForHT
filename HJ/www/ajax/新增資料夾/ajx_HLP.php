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
	$objResponse->assign("msg","innerHTML",nl2br(print_r($formData, true)));
	//取值如何
	//值如何給?update 又如何區分
	//$query="insert into sys_category (form_type,display,val,sno,enable,img_path) values('$type','1','?','0','1','')";
	//$res=MDB2_query($mdb2 ,$query);
	
	//$objResponse->assign("msg","innerHTML",$query);
	$objResponse->addAlert($type."類別已新增");
	//$objResponse->script('location.reload();');
	return $objResponse;	
}/**/
?>