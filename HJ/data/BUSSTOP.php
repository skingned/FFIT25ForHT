<?php
/*********************************************
目地:取出站點資料
來源:MySQL--->JSON
*********************************************/
 header('Access-Control-Allow-Origin: *');
 header("Content-Type:text/html; charset=utf-8");
 //====================init ===================
include_once "config.php";
if (!empty($_GET)){
	$max=empty($_GET["max"])?10:$_GET["max"];
			//=====================link to mysql ==============================
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	}
	$mysqli->query("set names utf8" );
	
	//$MySql_query="select id,PositionLat as lat,PositionLon as lng ,'../images/icon/busstop.png' as icon,Zh_tw as title, StopAddress as addr ,'站名'  as content  from od_bsstop";
		$MySql_query="select p.id,p.lat,p.lng ,p.icon,p.title, p.addr ,p.content ,p.StopUID,r.Zh_tw as rname
				  from (select id,PositionLat as lat,PositionLon as lng ,'../images/icon/busstop.png' as icon,Zh_tw as title, StopAddress as addr ,'站名'  as content ,StopUID
				  from od_bsstop )as p left join od_bsrs as br on p.StopUID=br.StopUID left join od_bsroute as r on br.RouteUID=r.RouteUID" ;
	/*	$MySql_query.=" union select p.id,p.lat,p.lng ,p.icon,p.title, p.addr ,p.content ,p.StopUID,r.Zh_tw as rname
				  from (select id,PositionLat as lat,PositionLon as lng ,'../images/icon/bustour.png' as icon,Zh_tw as title, StopAddress as addr ,'站名'  as content ,StopUID
				  from od_ibsstop )as p left join od_ibsrs as br on p.StopUID=br.StopUID left join od_ibsroute as r on br.RouteUID=r.RouteUID" ;*/
				  
	if ($result = $mysqli->query($MySql_query)) {
		while($row = $result->fetch_array(MYSQL_ASSOC)) {
				$myArray[] = $row;
		}
	echo json_encode(array("markers" =>$myArray));
	}
	$result->close();	
	$mysqli->close();
}

?>