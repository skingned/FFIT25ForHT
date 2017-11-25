<?php

@session_start();
require_once ("../dist/js/xajax_core/xajax.inc.php");
$xajax = new xajax();
$ajxobj=$xajax->registerFunction("del");
$ajxobj=$xajax->registerFunction("left");
$ajxobj=$xajax->registerFunction("order");
//$ajxobj->useSingleQuote();
//$ajxobj->addParameter(XAJAX_INPUT_VALUE,"org");
$xajax->processRequest();


//刪除
function del($id){   
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);
	$query="DELETE FROM slider WHERE id='$id'"; //刪了自己這一筆
	$res=MDB2_query($mdb2 ,$query);
	//$objResponse->addAlert($id." 已刪除");
	//$_SESSION['ajaxreload']="y";
	$objResponse->script('location.reload();');
	return $objResponse;	
}

//排序
function order($id,$type){   
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);
	
	//find sno
	$query="select sno from slider where id ='$id'";
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();
	
	//~UP/DOWN
	switch(strtoupper($type)){
		case "UP":
			if ($rows[0] > 0){
				$val=$rows[0]-1;
				$query="update slider set sno='$val' where id='".$id."'";
				$res=MDB2_query($mdb2 ,$query);			
				$msg=$id."排序已向前";
			}else{
				$msg=$id."已到最前";
			}			
		break;
		case "DOWN":			
			if ($rows[0] < ORDERMAX){//限制排序最大值
				$val=$rows[0]+1;
				$query="update slider set sno='$val' where id='".$id."'";
				$res=MDB2_query($mdb2 ,$query);			
				$msg=$id."排序已向後";
			}else{
				$msg=$id."已到最後(".ORDERMAX.")";
			}			
		break;
	}
	//如何顯示結果,重整
	//1.變更dataTables-example-2的內容
	//2.reload lightbox_me

	//$_SESSION['ajaxreload']="y";
	//try to reload
	$objResponse->script('location.reload();');//run 就掛 <==不run 如何更新資料

	$objResponse->addAlert($msg);
	//$objResponse->script('location.reload();');
	return $objResponse;	
}


?>