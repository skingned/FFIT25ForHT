<?php 
require_once ("../dist/js/xajax_core/xajax.inc.php");
$xajax = new xajax();
$xajax->registerFunction("repwd");
$xajax->registerFunction("dacc");
$xajax->registerFunction("cacc");
$ajxobj=$xajax->registerFunction("chgpage");

//$ajxobj->useSingleQuote();
//$ajxobj->addParameter(XAJAX_INPUT_VALUE,"org");
$xajax->processRequest();
function repwd($id){   //改密碼
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);	
	$query="update account set pwd ='qaz@1234' where sno='$id'";
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();	
	$query="select id from account where sno='$id'";
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();	
	$msg=$rows[0]."密碼已重設";
	$objResponse->addAlert($msg);		
	return $objResponse;	
}
function dacc($id){  //刪帳號
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);	
	$query="select id from account where sno='$id'";
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();	
	$msg=$rows[0]."帳號已刪除";
	
	$query="delect from account where sno='$id'";
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();
	
	$objResponse->addAlert($msg);		
	return $objResponse;	
}
function cacc($id,$ouid,$spec){  //新帳號
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);	
	$ouid = GetOUID($ouid,$mdb2);
	$query="insert into account (id,ouid,spec) VALUES ( '$id','$ouid','$spec')";
	//$objResponse->addAlert($query);
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();
	$msg=$id."帳號已建立";
	$objResponse->addAlert($msg);		
	//$objResponse->assign("msg","innerHTML",$query);
	return $objResponse;	
}
function chgpage( $pagenumber ){
	$objResponse = new xajaxResponse();
	$pagenumber--;
	$mdb2 = MDB2_connect(DB_DNS);	
	$query="select sno,ouname ,spec, id, log from account,oulist where account.ouid=oulist.ouid and account.ouid in (select ouid from oulist where gid='$pagenumber')";

	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchAll();
	$htmlout='<table class="tablely" style="width: 690px;"><tr><th>機關單位名稱</th><th>承辦人(註解)</th><th>帳號</th><th >上次登入</th><th>功能</th></tr>';

	foreach ($rows as $values){
		$htmlout.='<tr>';
		foreach ($values as $key=>$value){			
			if ($key > 0){
			if ($value=="")
				$value="&nbsp;";
			$htmlout.='<td>'.$value.'</td>';
			}
		}
		$htmlout.='<td><a class="btn" onclick="javascript:xajax_repwd('.$values[0].')">[重設密碼]</a>|&nbsp;<a class="btn" onclick="javascript:xajax_dacc('.$values[0].')">[刪除]</a></td></tr>';
	}
	$htmlout.='</table>';
	$objResponse->assign("answer","innerHTML",$htmlout);
	return $objResponse;
}


?>