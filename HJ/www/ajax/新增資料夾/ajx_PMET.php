<?php
@session_start();
require_once ("../dist/js/xajax_core/xajax.inc.php");
$xajax = new xajax();
/*$xajax->registerFunction("ResetPWD");
$xajax->registerFunction("dacc");
$xajax->registerFunction("cacc");*/
//$ajxobj=$xajax->registerFunction("ResetPWD");
$ajxobj=$xajax->registerFunction("del");
/*$ajxobj=$xajax->registerFunction("DSB");
$ajxobj=$xajax->registerFunction("PWR");
$ajxobj=$xajax->registerFunction("ChgPWD");*/
//$ajxobj->useSingleQuote();
//$ajxobj->addParameter(XAJAX_INPUT_VALUE,"org");
$xajax->processRequest();

function del($id){   
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);	
	$query="DELETE FROM menu WHERE id=".id;
	$res=MDB2_query($mdb2 ,$query);
	$objResponse->assign("msg","innerHTML",$query);
	$objResponse->addAlert($acc." 已刪除");
	$objResponse->script('location.reload();');
	return $objResponse;	
}
?>