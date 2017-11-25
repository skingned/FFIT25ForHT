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
	
	
//	$MySql_query="select id,Py as lat,Px as lng ,'../images/icon/restaurant.png' as icon,name as title,`Add` as addr ,Description  as content  from od_ssrf where `Add` like '%新竹%'";
	//新竹縣市旅館
	$MySql_query.=" select `旅館名稱` as name,lng  ,lat ,'fa-home' as type,`地址` as addr, CONCAT('od_scht@',sno) as id, '../images/icon/hostel_0star.png' as icon ,'content' as content FROM od_scht"; 
	$MySql_query.=" union select `旅館名稱` as name,`緯度` as lat,`經度` as lng,'fa-home' as type,`營業地址` as addr, CONCAT('od_ssht@',sno) as id, '../images/icon/hostel_0star.png' as icon,'content' as content FROM od_ssht "; 

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