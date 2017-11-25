<?php 
require_once ("../dist/js/xajax_core/xajax.inc.php");
$xajax = new xajax();
//$xajax->debugOn();
$xajax->setTimeout('1000');
$ajxobj=$xajax->registerFunction("saveouuser");
$xajax->processRequest();

function saveouuser($username,$usertp,$tel,$email,$opwd,$npwd,$cpwd){
$objResponse = new xajaxResponse();
	$err=0;
	if ($username=="" ){
		$objResponse->addAlert("請輸入姓名");
		$err=1;
	}
	if ($usertp=="" ){
		$objResponse->addAlert("請輸入職稱");
		$err=1;	
	}
	if ($tel==""){
		$objResponse->addAlert("請輸入電話");
		$err=1;	
	} 
	if ($email==""){
		$objResponse->addAlert("請輸入電子郵件信箱");		
		$err=1;
	}	
	if ($err==0){
	$mdb2 = MDB2_connect(DB_DNS);//資料庫連線	
	$query="select sno,pwd from account where id='".$_SESSION['USR']['UID']."'";
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();	
	//如有改密碼
	$pwerr=0;
	if ($opwd <> "" or $npwd <> "" or $cpwd <> ""){	
		$pw="";
		if ($npwd == $cpwd){  
				
			if (trim($opwd) == trim($rows[1])){				
				//$objResponse->addAlert($opwd . ":" . $rows[1]);
				$pw= " , pwd='$npwd' ";
				$pwerr=0;
				
			}else{
				$objResponse->addAlert("原密碼不正確");//.$opwd .":".$rows[1]);
				$pwerr=1;
			}
		}else{			
			$objResponse->addAlert("新密碼與確認碼不相符");
			$pwerr=1;
		}		
	}
	if ($pwerr==0){
		$query="update account set spec='$username',spec1='$usertp' , tel='$tel' ,email='$email' $pw where sno='$rows[0]'";
		$res=MDB2_query($mdb2 ,$query);
		$rows=$res->fetchRow();			
		$_SESSION['USR']['NAME']=$username.$usertp;//使用者姓名
		$_SESSION['USR']['TEL']=$tel;//使用者電話
		$_SESSION['USR']['EMAIL']=$email;//使用者E-MAIL
		$msg= "資料已更新";
		$objResponse->addAlert($msg);
		//修改session?
	}	}
	return $objResponse;		
}

?>