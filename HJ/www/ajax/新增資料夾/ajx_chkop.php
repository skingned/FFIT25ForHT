<?php 
require_once ("../dist/js/xajax_core/xajax.inc.php");
$xajax = new xajax();
//$xajax->debugOn();
$xajax->registerFunction("Yearchk");

$xajax->processRequest();

function Yearchk($pagenumber){		
	$objResponse = new xajaxResponse();
	//if ($pagenumber !=""){
	$objResponse->assign("folid","innerHTML",$pagenumber."年");
	$objResponse->assign("yfolid","value",$pagenumber."年");
			
	$mdb2 = MDB2_connect(DB_DNS);//資料庫連線	
	$query="select ouname,ouid from oulist order by gid asc, ouid asc";		
	$res=MDB2_query($mdb2 ,$query);	
	$rows1=$res->fetchAll();			
	
	foreach ($rows1 as $key =>$value){
		for ($i=1;$i<=12;$i++){	
		$query="select sno  from eventdb,oulist  where RT_Y='$pagenumber'  and RT_M ='".$i."' and UID='$value[1]' AND EVENTDB.UID = OULIST.OUID  order by RT_M asc";		
		//$querylist .=$query."<Br>";
		$res=MDB2_query($mdb2 ,$query);	
		$rows=$res->fetchRow();			
		if ($rows[0]=="" or $rows[0]==null){
			//$TP_ARRAY[$key][$i]="";
			$objResponse->assign("a".$key."b".$i,"style.background","red");
		}else{
			//$TP_ARRAY[$key][$i]="v";
			$html="<a href='?mode=updata&ouid=$value[1]&y=$pagenumber&m=$i' >v</a>";
			$objResponse->assign("a".$key."b".$i,"innerHTML",$html);		
		}
		//$tmp_array[$i]=$rows;								
	}	
	}
/*
		$TPARRAYHTML ="<table border='1' sytle='color:red'>";
		foreach ($TP_ARRAY as $key=>$values){
			$TPARRAYHTML .="<tr>";
			foreach ($values as $key1=>$value){//欄位			 
					$TPARRAYHTML .= "<td>[".$key."][".$key1."]=".$value."</td>";
				}	
				$TPARRAYHTML .="</tr>";		
		}	
		$TPARRAYHTML .="</table>";			
	$objResponse->assign("msg","innerHTML",$TPARRAYHTML);
*/	
	
/*	}else{
		$objResponse->addAlert(" 請選擇年度 ");
	}*/
	return $objResponse;
}


?>