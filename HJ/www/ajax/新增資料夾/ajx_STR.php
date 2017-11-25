<?php

@session_start();
require_once ("../dist/js/xajax_core/xajax.inc.php");
$xajax = new xajax();
//$xajax->registerFunction("ResetPWD");
//$xajax->registerFunction("dacc");
//$xajax->registerFunction("cacc");

$ajxobj=$xajax->registerFunction("sample");

//$ajxobj->useSingleQuote();
//$ajxobj->addParameter(XAJAX_INPUT_VALUE,"org");
$xajax->processRequest();

function sample($acc,$power,$mail){   
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);	
	$query="insert into  sys_acc (acc,power,email,pwd,spec,spec1,ou_id,area_id) values('$acc','$power','$mail','a545f9a48df4be512630cc53cee1916b','$acc','$acc',0,0)";
	$res=MDB2_query($mdb2 ,$query);
	$objResponse->assign("msg","innerHTML",$query);
	$objResponse->addAlert($acc." 帳號已新增");
	$objResponse->script('location.reload();');
	return $objResponse;	
}/**/
?>