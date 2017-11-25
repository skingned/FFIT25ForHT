<?php
@session_start();
require_once ("../dist/js/xajax_core/xajax.inc.php");
$xajax = new xajax();
/*$xajax->registerFunction("GetItems");
$xajax->registerFunction("dacc");
$xajax->registerFunction("cacc");
$ajxobj=$xajax->registerFunction("GetItems");*/
$ajxobj=$xajax->registerFunction("AddOwner");
$ajxobj=$xajax->registerFunction("ChgState");
//$ajxobj->useSingleQuote();
//$ajxobj->addParameter(XAJAX_INPUT_VALUE,"org");
$xajax->processRequest();
function ChgState($id,$state){
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);
	
	$query="update tsc_meet_items set state='$state' where id='$id'";
	$res=MDB2_query($mdb2 ,$query);
	
	if ($state =='C'){			
		$query="update r_meet_items_acc set close_day=now() where items_id='$id'";					
	}elseif ($state =='O'){			
		$query="update r_meet_items_acc set close_day='' where items_id='$id'";
			
	}
	$res=MDB2_query($mdb2 ,$query);
	$objResponse->alert("state set");
	return $objResponse;
}


function AddOwner($owner,$items_id){   
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);	
	$query="insert into r_meet_items_acc (items_id , owner) values ('$items_id','$owner')";
	$res=MDB2_query($mdb2 ,$query);
	
	
	
	//$objResponse->assign("sql","innerHTML",$query);
	//清除本身的資料
	$query="delete from r_meet_items_acc where items_id='$items_id' and owner='".$_SESSION['USR']['UID']."'";
	$res=MDB2_query($mdb2 ,$query);
	//=======
	//$objResponse->assign("answer","innerHTML",$html);
	//$objResponse->script('$(".datetype").datepicker({ dateFormat: "yy-mm-dd" });');//要重新定義一次日期元件的動作
	$objResponse->alert('已增加 '. $owner .'為該項 owner');
	return $objResponse;	
}


?>