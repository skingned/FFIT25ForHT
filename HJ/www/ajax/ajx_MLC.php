<?php
@session_start();
require_once ("../js/xajax_core/xajax.inc.php");
$xajax = new xajax();
/*$xajax->registerFunction("ResetPWD");
$xajax->registerFunction("dacc");
$xajax->registerFunction("cacc");*/
$ajxobj=$xajax->registerFunction("ResetPWD");

//$ajxobj->useSingleQuote();
//$ajxobj->addParameter(XAJAX_INPUT_VALUE,"org");
$xajax->processRequest();
function ResetPWD($id){   
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);	
	$query="update sys_acc set pwd='a545f9a48df4be512630cc53cee1916b' where acc='$id'";
	$objResponse->assign("msg","innerHTML",$query);
	$res=MDB2_query($mdb2 ,$query);
	$objResponse->addAlert($id." 密碼已重設");
	return $objResponse;	
}

?>