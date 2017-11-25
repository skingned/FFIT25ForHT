<?php
@session_start();
require_once ("../dist/js/xajax_core/xajax.inc.php");
$xajax = new xajax();

$ajxobj=$xajax->registerFunction("CreatePRD");
$ajxobj=$xajax->registerFunction("addPRD");

$xajax->processRequest();

function CreatePRD($form,$PID){   
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);	
	$objResponse->assign("msg","innerHTML",nl2br(print_r($form, true)));//查看
	$objResponse->append("msg","innerHTML","<BR>".$PID);
	//?NULL
//增加到product
//	$query="insert into products () values ('$acc','$power','$mail','a545f9a48df4be512630cc53cee1916b','$acc','$acc',0,0)";
//	$res=MDB2_query($mdb2 ,$query);
	
/*
	//取得ID
	$query="Select id from products where ='' and =''";
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();
	//增加對應
	$query="insert into r_menu_products (menu_products_id,products_id,SNO,USER_ID) "
		  ." values('$PID','".$rows[0]."','1','".$_SESSION['USR']['NAME']."')";
	$res=MDB2_query($mdb2 ,$query);
	$objResponse->script('location.reload();');//重載入就會看到
	
*/
	
//	$objResponse->assign("msg","innerHTML",$query);
//	$objResponse->addAlert("產品已新增");
	
	
	//
	return $objResponse;	
}

function addPRD($Itmelist,$PID){  //鈎選方式加入
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);	
	//$objResponse->addAlert("選取的要寫入db ".$PID);
	$items=split (',', $Itmelist);
	foreach ($items as $k=>$v){
		$sno=$k+1;
		$query="insert into r_menu_products (menu_products_id,products_id,SNO,USER_ID) values('".$PID."','".$v."','". $sno ."','".$_SESSION['USR']['NAME']."')";
		//$objResponse->append("msg","innerHTML","$query<br>");//查看
		$res=MDB2_query($mdb2 ,$query);
	}
	//$objResponse->script('location.reload();');//重載入就會看到
	return $objResponse;	
}

?>