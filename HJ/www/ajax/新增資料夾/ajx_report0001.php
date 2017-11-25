<?php 
require_once ("../dist/js/xajax_core/xajax.inc.php");
$xajax = new xajax();
//$xajax->debugOn();
$xajax->registerFunction("Yearchk");
$xajax->registerFunction("mchk");
$xajax->processRequest();

function Yearchk($pagenumber){	
	$objResponse = new xajaxResponse();
	if ($pagenumber !=""){
	$objResponse->assign("folid","innerHTML",$pagenumber."年");
	$objResponse->assign("yfolid","value",$pagenumber."年");
	//清空
	//for ($i=YEAR_START;$i <=YEAR_END;$i++){
	//	$objResponse->assign("y".$i,"style.background","url(../images/formbg.gif) repeat-x left top");
	//}
	//$objResponse->assign("y".$pagenumber,"style.background","#194DE3");
	//查那些有填報過
	$mdb2 = MDB2_connect(DB_DNS);//資料庫連線	
	$query="select RT_M from eventdb where RT_Y='$pagenumber' and UID ='".$_SESSION['OUE']['OUID']."' order by RT_M asc";	
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchAll();	
	//清空
	for ($i=1;$i <=12;$i++){
		$objResponse->assign("tdbg".$i,"style.background","#fff");
		$objResponse->assign("mx".$i,"innerHTML",$i."月");
	}
	//指定	
	foreach ($rows as $key1=>$value1){
		foreach ($value1 as $key=>$value){						
			$objResponse->assign("mx".$value,"innerHTML","(".$value."月)");
			$objResponse->assign("tdbg".$value,"style.background","yellow");			
		}
	}
	}else{
		$objResponse->addAlert(" 請選擇年度 ");
	}	
	return $objResponse;
}
function mchk($pagenumber,$y){	
	$objResponse = new xajaxResponse();
	if ($y==""){
	$objResponse->addAlert("年度尚未輸入!");		
	}else{
		$objResponse->assign("mfolid","innerHTML",$pagenumber."月");
		$objResponse->assign("m1folid","value",$pagenumber."月");		
		//抓出填過的資料
		$YM=str_replace("年","",$y);  
		$mdb2 = MDB2_connect(DB_DNS);//資料庫連線	
		$query="select A1+B1+C1+A2+B2+C2 AS D,A1+B1+C1 AS D1,A2+B2+C2 AS D2,A1+A2 AS A,A1,A2,B1+B2 AS B,B1,B2,C1+C2 AS C,C1,C2,account ,tel from eventdb where RT_Y='$YM' and RT_M='$pagenumber' and UID ='".$_SESSION['OUE']['OUID']."' order by RT_M asc";
		$res=MDB2_query($mdb2 ,$query);
		$rows=$res->fetchRow();		
		if (is_array($rows)){		
			foreach ($rows as $key=>$value){			
				$objResponse->assign("a".$key,"innerHTML",$value);	}
			$objResponse->assign("s1","style.display","block");						 
			$objResponse->assign("s2","style.display","none");
		}else{
			$objResponse->assign("a12","innerHTML",$_SESSION['USR']['NAME']);
			$objResponse->assign("a13","innerHTML",$_SESSION['USR']['TEL']);
			$objResponse->assign("s1","style.display","none");
			$objResponse->assign("s2","style.display","block");			
		}		
	}	
	return $objResponse;
}

?>