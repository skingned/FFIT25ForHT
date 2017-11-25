<?php
@session_start();
require_once ("../dist/js/xajax_core/xajax.inc.php");
$xajax = new xajax();
/*$xajax->registerFunction("ResetPWD");
$xajax->registerFunction("dacc");
$xajax->registerFunction("cacc");*/
$ajxobj=$xajax->registerFunction("ResetPWD");
$ajxobj=$xajax->registerFunction("Caccount");
$ajxobj=$xajax->registerFunction("DSB");
$ajxobj=$xajax->registerFunction("PWR");
$ajxobj=$xajax->registerFunction("ChgPWD");
//$ajxobj->useSingleQuote();
//$ajxobj->addParameter(XAJAX_INPUT_VALUE,"org");
$xajax->processRequest();

function Caccount($acc,$power,$mail){   
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);	
	$query="insert into  sys_acc (acc,power,email,pwd,spec,spec1,ou_id,area_id) values('$acc','$power','$mail','a545f9a48df4be512630cc53cee1916b','$acc','$acc',0,0)";
	$res=MDB2_query($mdb2 ,$query);
	$objResponse->assign("msg","innerHTML",$query);
	$objResponse->addAlert($acc." 帳號已新增");
	$objResponse->script('location.reload();');
	return $objResponse;	
}
function ChgPWD($id,$opwd,$npwd){
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);
	$opwd=md5(trim($opwd));
	$npwd=md5(trim($npwd));
	$query="update sys_acc set pwd='$npwd' where acc='$id' and pwd='$opwd'";
	$objResponse->assign("msg","innerHTML",$query);
	$res=MDB2_query($mdb2 ,$query);	
	$objResponse->addAlert($id." 密碼已變更");
	$objResponse->script('$("#cpwdx").hide();');	
	return $objResponse;	
}
function ResetPWD($id){   
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);	
	$query="update sys_acc set pwd='a545f9a48df4be512630cc53cee1916b' where acc='$id'";
	$objResponse->assign("msg","innerHTML",$query);
	$res=MDB2_query($mdb2 ,$query);
	$objResponse->addAlert($id." 密碼已重設");
	return $objResponse;	
}

function DSB($id,$val){   
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);	
	$query="update sys_acc set disable='$val' where acc='$id'";
	$objResponse->assign("msg","innerHTML",$query);
	$res=MDB2_query($mdb2 ,$query);
	$objResponse->addAlert($id." 帳號已停用");
		return $objResponse;	
}
function PWR($id,$val){   
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);	
	$query="update sys_acc set power='$val' where acc='$id'";
	$objResponse->assign("msg","innerHTML",$query);
	$res=MDB2_query($mdb2 ,$query);
	$objResponse->addAlert($id." 權限已變更");
	return $objResponse;	
}

?>