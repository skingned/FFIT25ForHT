<?php
@session_start();
/*query meet name & response json format*/
include_once ("../../include.php");
//==sql injection=====
$_POST=quotes($_POST);
$_GET=quotes($_GET);
$meet_type=$_GET['MT'];
	$mdb2 = MDB2_connect(DB_DNS);//資料庫連線	
	$query = "select  id,name from TSC_MEET  where state='O' and type_id='$meet_type' order by id desc ";
	if ($_GET['DMT']=='Y')
		$query = "select  id,type_id,name,meetDate,state,Chairman_id,recording_ID,menber_list,attachment from TSC_MEET  where state='O' and id='$meet_type' order by meetDate asc";
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchAll();	
	echo  json_encode($rows);	
?>