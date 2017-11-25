<?php
@session_start();
/*query meet name & response json format*/
include_once ("../../include.php");
//==sql injection=====
$_POST=quotes($_POST);
$_GET=quotes($_GET);
$_GET['hid']= strtoupper($_GET['hid']);
//驗証格式  x-x-x
if (preg_match("/^\w+(-)+\w+(-)+\w+$/", $_GET['hid'])){	//單頭
	$para=preg_split("/[-,]+/",$_GET['hid']);
	$mdb2 = MDB2_connect(DB_DNS);//資料庫連線
	$query="select id,area,floor,sno from households where area='".$para[0]."' and floor='".$para[1]."' and sno='".$para[1]."' and PJ_ID='".$_SESSION['PJ']['ID']."'";
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();
		//var_dump($rows);
	//$query="select from households_dtl where h_id='".$rows[0]."'"
	echo  json_encode($rows);
}
	
?>