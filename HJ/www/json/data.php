<?php
@session_start();
include_once ("../../include.php");
	$mdb2 = MDB2_connect(DB_DNS);//資料庫連線
	$query="select s.id,lat as latitude,lng as longitude ,si.path as icon,name as title,content from store as s left join store_icon as si on si.store_id=s.id";
	$res=MDB2_query($mdb2 ,$query);	
	$rows=$res->fetchAll(MDB2_FETCHMODE_ASSOC);
	//var_dump($rows);//要設定名字
	echo json_encode(array('markers'=>$rows));
/*
$markers=array("markers" => array(
array("id"=>"1475","latitude"=>"25.062315","longitude"=>"121.56769299999996","icon"=>"images/computers.png","title"=>"0000有限公司","content"=>"說明文字"),
array("id"=>"1474","latitude"=>"24.957537","longitude"=>"121.31250599999998","icon"=>"images/computers.png","title"=>"xxxx企業社","content"=>"xxxx企業社說明文字")
));
//var_dump($markers);
echo json_encode($markers);*/


?>