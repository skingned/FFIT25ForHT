<?php
/* require the store_id as the parameter */
/*利用api做轉換 twd97=>wgs84*/

//http://taibif.org.tw/BDTools/proj4/convert.php?source=5&destination=1&x=123456&y=2234567
# API URL：http://taibif.org.tw/BDTools/
# 參數說明：transl(sourceSystem, targetSystem, x, y)
# sourceSystem: 來源坐標系統
# targetSystem: 欲轉換的座標系統
#     1: WGS 84 經緯度
#     2: TWD 67 經緯度
#     3: TWD 97 經緯度
#     4: TWD97/ 澎湖地區
#     5: TWD97/ 臺灣地區
#     6: TWD67/ 澎湖地區
#     7: TWD67/ 臺灣地區
# x: X 坐標 lon 東西經度, longitude E
# y: Y 坐標 lat 南北緯度, latitude N
# 回傳：轉換後的經緯度 dataframe

//查出來源
include_once "config/config.php";
$table="od_fire_fh";
$query="select id,x97,y97 from $table where lng=''";// limit 0,10";

$result = mysql_query($query,$link) or die('Errant query:  '.$query);
		while($rows=mysql_fetch_assoc($result)){							
				$wgs84=tw97to84($url,$rows['x97'],$rows['y97']);	
				// var_dump($wgs84);
				//寫回db
				$query="update $table set lat='".$wgs84[1]."',lng='".$wgs84[0]."' where id='".$rows['id']."'"; 
				echo $query."<br>";
				$resultx = mysql_query($query,$link) or die('Errant query:  '.$query);
			}
		
@mysql_close($link);






function tw97to84($url,$x,$y){//取得來源並將 XML 或JSON 統一為JSON 格式輸出
	//$url=trim($url);
	$url='http://taibif.org.tw/BDTools/proj4/convert.php?source=5&destination=1&x='.$x.'&y='.$y;
	$proxy_port="8888";
	$proxy_ip="proxy.ts.com.tw";
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url ); 
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'Get');
	curl_setopt($ch, CURLOPT_POST, 0 ); 
	//curl_setopt($ch, CURLOPT_POST, 1 ); 
	curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);//301
	if (substr(getHostByName(getHostName()),0,8) <> "192.168."){
		//proxy
		curl_setopt($ch, CURLOPT_PROXYPORT, $proxy_port);
		curl_setopt($ch, CURLOPT_PROXY, $proxy_ip);
		//   curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP'); 
	
	}
	
	//是ssl
	//echo strtoupper($url)."<br>";
	if (substr(strtoupper($url),0,8)=="HTTPS://"){
		//echo "HTTPS <br>";
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	}
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	$postResult = trim(curl_exec($ch)); 

	if (curl_errno($ch)) { 
	   print curl_error($ch); 
	} 
	curl_close($ch);
	$lin1=explode( 'Conversion : ', $postResult );
	if (!empty($lin1[1])){
		$lin1=explode( '<br>', $lin1[1] );
		$postResult=explode(' ',$lin1[0]);
	}else{
		$postResult=array('','');
	}
	//("<br>Conversion : ")
	return $postResult;//只取內容
}


?>