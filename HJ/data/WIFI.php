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
	$MySql_query="select id,LATITUDE as lat,LONGITUDE as lng ,'../images/icon/wifi.png' as icon,name as title,addr ,AGENCY as content  from od_wifi where `ADDR` like '%新竹%'";
	//echo "$MySql_query<br>";
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