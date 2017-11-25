<?php
@session_start();
/*query meet name & response json format*/
include_once ("../../include.php");
//==sql injection=====
$_POST=quotes($_POST);
$_GET=quotes($_GET);
//驗証格式  x-x-x
$_GET['zip']=$trim($_GET['zip']);
if (!empty($_GET['zip'])){	//單頭
	$mdb2 = MDB2_connect(DB_DNS);//資料庫連線
	$query="select zip,villname from households where zip='".$_GET['zip']."' order by villname asc ";
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchAll();
	echo  json_encode($rows);
}
	
?>