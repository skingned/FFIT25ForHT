<?php 
require_once ("../dist/js/xajax_core/xajax.inc.php");
$xajax = new xajax();
//$xajax->debugOn();
$xajax->registerFunction("upoupost");
$xajax->processRequest();
function upoupost($sno,$a1,$a2,$b1,$b2,$c1,$c2){
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);//資料庫連線		
	$query="update eventdb set A1='$a1',A2='$a2',B1='$b1',B2='$b2',C1='$c1',C2='$c2' where sno='$sno'";
		
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();		
	$msg= "資料已更新";
	$objResponse->addAlert($msg);
	//======================
	$query="select A1,A2,B1,B2,C1,C2 from eventdb where sno='$sno' ";	
		
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();		
	$objResponse->assign("A1","value",$rows[0]);
	$objResponse->assign("A2","value",$rows[1]);
	$objResponse->assign("B1","value",$rows[2]);
	$objResponse->assign("B2","value",$rows[3]);
	$objResponse->assign("C1","value",$rows[4]);
	$objResponse->assign("C2","value",$rows[5]);	
	$objResponse->assign("f1","innerHTML",$rows[0]+$rows[2]+$rows[4]);
	$objResponse->assign("f2","innerHTML",$rows[1]+$rows[3]+$rows[5]);
	//=======================
	return $objResponse;
}


?>