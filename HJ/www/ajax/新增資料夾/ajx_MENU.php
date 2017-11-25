<?php
@session_start();
require_once ("../dist/js/xajax_core/xajax.inc.php");
$xajax = new xajax();

$ajxobj=$xajax->registerFunction("del");
$ajxobj=$xajax->registerFunction("left");
$ajxobj=$xajax->registerFunction("order");


/*$ajxobj=$xajax->registerFunction("DSB");
$ajxobj=$xajax->registerFunction("PWR");
$ajxobj=$xajax->registerFunction("ChgPWD");*/
//$ajxobj->useSingleQuote();
//$ajxobj->addParameter(XAJAX_INPUT_VALUE,"org");
$xajax->processRequest();
//刪除
function del($id){   
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);
	
	$objResponse->assign("skingmsg","innerHTML","return :".nl2br(print_r(delLoop($id,$mdb2),true)));
	$objResponse->addAlert($id." 已刪除");
	$objResponse->script('location.reload();');
	return $objResponse;	
}
//上移一層
function left($id){   
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);

	$query="select up_id from menu where id = (SELECT up_id from menu WHERE id='".$id."')";//子id也要刪
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();	
	
	$query="update menu set up_id='".$rows[0]."' where id='".$id."'";
	$res=MDB2_query($mdb2 ,$query);	
	//	$objResponse->assign("msg","innerHTML",$query);
	$objResponse->addAlert($id." 已上移一層");
	$objResponse->script('location.reload();');
	return $objResponse;	
}
//排序
function order($id,$type){   
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);
	
	//find sno
	$query="select sno from menu where id ='$id'";
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();
	
	//~UP/DOWN
	switch(strtoupper($type)){
		case "UP":
			if ($rows[0] > 0){
				$val=$rows[0]-1;
				$query="update menu set sno='$val' where id='".$id."'";
				$res=MDB2_query($mdb2 ,$query);			
				$msg=$id."排序已向前";
			}else{
				$msg=$id."已到最前";
			}			
		break;
		case "DOWN":			
			if ($rows[0] < ORDERMAX){//限制排序最大值
				$val=$rows[0]+1;
				$query="update menu set sno='$val' where id='".$id."'";
				$res=MDB2_query($mdb2 ,$query);			
				$msg=$id."排序已向後";
			}else{
				$msg=$id."已到最後(".ORDERMAX.")";
			}			
		break;
	}

	$objResponse->addAlert($msg);
	$objResponse->script('location.reload();');
	return $objResponse;	
}

//function
//刪除子功能
function delLoop($id,$mdb2){//子項也要刪除
	$query="DELETE FROM menu WHERE id='$id'"; //刪了自己這一筆
	$res=MDB2_query($mdb2 ,$query);
	
	$query="SELECT id from menu WHERE up_id='$id'";//子id也要刪
	
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchAll();	
	
	//$objResponse->assign("msg","innerHTML",nl2br(print_r($rows,true)));
	foreach($rows as $k=>$v){
		$rt=delLoop($rows[$k][0],$mdb2);
	}
	return true;
	
}
?>