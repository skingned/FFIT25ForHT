<?php 
require_once ("../dist/js/xajax_core/xajax.inc.php");
$xajax = new xajax();
//$xajax->debugOn();
/*$xajax->registerFunction("GetItems");
*/
$ajxobj=$xajax->registerFunction("GetMeet");

//$ajxobj->useSingleQuote();
//$ajxobj->addParameter(XAJAX_INPUT_VALUE,"org");
$xajax->processRequest();
function GetMeet($id){   //改密碼
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);	
	//帶出所選的會議資料
	$query="select rec from tsc_meet where id='$id' "; //
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();
	//?指定到欄位
	//$objResponse->alert($rows);
	$objResponse->assign("REC","innerHTML",$rows[0]);
	
	//$objResponse->assign("Createday",'value',);
	//$objResponse->assign("debug","innerHTML",$query);
	//=======
	//$objResponse->assign("answer","innerHTML",$html);//指定元件值
	
	//$objResponse->assign("debug","innerHTML",$debugtxt);
	//$objResponse->script('$(".datetype").datepicker();');//要重新定義一次日期元件的動作
	return $objResponse;	
}

?>
