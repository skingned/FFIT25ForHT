<?php
@session_start();
/*query meet name & response json format*/
include_once ("../../include.php");
//==sql injection=====
$_POST=quotes($_POST);
$_GET=quotes($_GET);
$meet_type=$_GET['MT'];
	$mdb2 = MDB2_connect(DB_DNS);//資料庫連線

	$query="";	

	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();	
	echo  json_encode($rows);	
?>