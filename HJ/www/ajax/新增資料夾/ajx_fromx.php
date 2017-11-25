<?php 
require_once ("../dist/js/xajax_core/xajax.inc.php");
$xajax = new xajax();
//$xajax->debugOn();


$xajax->registerFunction("Yearchk");
$xajax->registerFunction("mchk");
//$xajax->registerFunction("upoupost");
$ajxobj=$xajax->registerFunction("saveoupost");
$xajax->processRequest();
/*
function upoupost($sno,$a1,$a2,$b1,$b2,$c1,$c2){
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);//資料庫連線		
	$query="update eventdb set A1='$a1',A2='$a2',B1='$b1',B2='$b2',C1='$c1',C2='$c2' where sno='$sno'";
	//$objResponse->addAlert($query);	
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();		
	$msg= "資料已更新";
	$objResponse->addAlert($msg);
	//======================
	$query="select A1,A2,B1,B2,C1,C2 from eventdb where sno='$sno' ";	
	//$objResponse->addAlert($query);		
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
}*/

function saveoupost($y,$m,$a1,$a2,$b1,$b2,$c1,$c2){
	$objResponse = new xajaxResponse();
	if ($y != 0 and $y !=null and $y!=""){
	$mdb2 = MDB2_connect(DB_DNS);//資料庫連線	
	$query="INSERT INTO eventdb (OID,UID,RTIME,RT_Y,RT_M,account,tel,A1,A2,B1,B2,C1,C2 )VALUES ('".$_SESSION['OUE']['ORG']."','".$_SESSION['OUE']['OUID']."','".date("Y-m-d H:i:s")."','$y','$m','".$_SESSION['USR']['NAME']."','".$_SESSION['USR']['TEL']."','$a1','$a2','$b1','$b2','$c1','$c2')";
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();	
	//$objResponse->assign("mx".$m,"innerHTML","(".$m."月)");
	//$objResponse->assign("tdbg".$m,"style.background","yellow");
	$msg= $y.$m."-資料已完成填報";
	$objResponse->assign("msg","innerHTML",$msg);
	$objResponse->addAlert($msg);	
	$objResponse->assign("savebtn","disabled","disabled");
	$objResponse->assign("savebtn","style.cursor","default");
	//查那些有填報過
	$query="select RT_M from eventdb where RT_Y='$y' and UID ='".$_SESSION['OUE']['OUID']."' order by RT_M asc";	
	//$objResponse->assign("msg","innerHTML",$query);
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
	$objResponse->addAlert("年度尚未輸入!");
	}
	return $objResponse;	
}
function Yearchk($pagenumber){	
	$objResponse = new xajaxResponse();
	
	if ($pagenumber !=""){
	$objResponse->assign("folid","innerHTML",$pagenumber."年");
	$objResponse->assign("yfolid","value",$pagenumber."年");
	//$objResponse->assign("savebtn","style.cursor","pointer");
	//$objResponse->assign("msg","innerHTML","");
	//清空
	for ($i=YEAR_START;$i <=YEAR_END;$i++){
		$objResponse->assign("y".$i,"style.background","url(../images/formbg.gif) repeat-x left top");
	}
	$objResponse->assign("y".$pagenumber,"style.background","#194DE3");
	$objResponse->assign("savebtn","disabled","disabled");
	$objResponse->assign("savebtn","style.cursor","default");
	
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
	//$pagenumber=100;
	$objResponse = new xajaxResponse();
	if ($y==""){
	$objResponse->addAlert("年度尚未輸入!");	
	//var_dump($htmlout);
	//$objResponse->assign("mfolid","innerHTML",$pagenumber."月");
	}else{
		$objResponse->assign("folid","innerHTML",$y.$pagenumber."月");
		$objResponse->assign("mfolid","value",$pagenumber."月");
		//$objResponse->assign("tdbg".$pagenumber,"style.background","#194DE3");
		//抓出填過的資料
		$YM=str_replace("年","",$y);  
		$mdb2 = MDB2_connect(DB_DNS);//資料庫連線	
		$query="select account,tel,A1,A2,B1,B2,C1,C2,sno from eventdb where RT_Y='$YM' and RT_M='$pagenumber' and UID ='".$_SESSION['OUE']['OUID']."' order by RT_M asc";			
		//$objResponse->assign("msg","innerHTML",$query);
		$res=MDB2_query($mdb2 ,$query);
		$rows=$res->fetchRow();
		$objResponse->assign("msg","innerHTML","");
		//$objResponse->assign("msg","innerHTML",$query);
		if (is_array($rows)){
		$objResponse->assign("mfolid","value",$pagenumber."月");
		$objResponse->assign("A1","value",$rows[2]);
		$objResponse->assign("A2","value",$rows[3]);
		$objResponse->assign("B1","value",$rows[4]);
		$objResponse->assign("B2","value",$rows[5]);
		$objResponse->assign("C1","value",$rows[6]);
		$objResponse->assign("C2","value",$rows[7]);
		$objResponse->assign("sno","value",$rows[8]);
		$objResponse->assign("f1","innerHTML",$rows[2]+$rows[4]+$rows[6]);
		$objResponse->assign("f2","innerHTML",$rows[3]+$rows[5]+$rows[7]);
		$objResponse->assign("savebtn","disabled","disabled");
		$objResponse->assign("upbtn","disabled","");
		$objResponse->assign("savebtn","style.cursor","default");
		}else{
		$objResponse->assign("A1","value",0);
		$objResponse->assign("A2","value",0);
		$objResponse->assign("B1","value",0);
		$objResponse->assign("B2","value",0);
		$objResponse->assign("C1","value",0);
		$objResponse->assign("C2","value",0);
		$objResponse->assign("f1","innerHTML",0);
		$objResponse->assign("f2","innerHTML",0);
		$objResponse->assign("savebtn","disabled","");
		$objResponse->assign("upbtn","disabled","disabled");
		$objResponse->assign("savebtn","style.cursor","pointer");
		}
	}
	
	return $objResponse;
}

?>