<?php
error_reporting(E_ALL ^ E_DEPRECATED);
ini_set("max_execution_time", "6000");
header("Content-Type: text/html; charset=utf-8"); 


define ('DB_USER','root');
switch (gethostname()){
	case "Sking":		
		define ('DB_PASS','!QAZ1qaz');		
	break;
	case "FFIT":
		define ('DB_PASS','Vac@lulala');
	break;
	default:
		define ('DB_PASS','Vac@lulala');
	break;
}

//***************設定DB***********************

define ('DB_HOST','localhost');
define ('DB_NAME','HJ');
	
//=======SYS===========================

$link = mysql_connect(DB_HOST,DB_USER,DB_PASS) or die('Cannot connect to the DB');
	mysql_query("SET NAMES UTF8");
	mysql_select_db(DB_NAME,$link) or die('Cannot select the DB');
echo "HOST IP:".getHostByName(getHostName())."<br>";//主機的

$NCDRURL=array(
/* 已驗證

	//新竹市合法旅館資料名冊
	'SSHT'=>'http://opendata.hccg.gov.tw/dataset/39ee314b-7ce7-4265-a6b5-b57f42392da8/resource/6a3a5f61-5383-419d-a94c-df710071a51e/download/20171026100731680.json',
	//新竹縣合法旅館資料名冊(沒有座標)
	'SCHT'=>'https://data.hsinchu.gov.tw/OpenData/GetFile.aspx?GUID=f6d5a158-88b3-44aa-a804-e9b775fd9db5&FM=json',//沒有座標要轉換
	//新竹縣市公車站牌
	"HCSTOP"=>"http://localhost:82/HJ/curl/hc.json",
	'HHSTOP'=>'http://localhost:82/HJ/curl/hh.json',

	//景點 - 觀光資訊資料庫
	'SSCF'=>'http://gis.taiwan.net.tw/XMLReleaseALL_public/scenic_spot_C_f.json',
	//活動 - 觀光資訊資料庫
	'SSAF'=>'http://gis.taiwan.net.tw/XMLReleaseALL_public/activity_C_f.json',
	//餐飲 - 觀光資訊資料庫
	'SSRF'=>'http://gis.taiwan.net.tw/XMLReleaseALL_public/restaurant_C_f.json',
	//餐飲 - 觀光資訊資料庫
	'SSRF'=>'http://gis.taiwan.net.tw/XMLReleaseALL_public/restaurant_C_f.json',
	//新竹縣市公車路線
	'RHCROT'=>'http://localhost:82/HJ/curl/rhc.json',
	'RHHROT'=>'http://localhost:82/HJ/curl/rhh.json',
	
*/		
	
	

	//=====================尚未處理==================================
	//新竹縣市公車路線+站牌	
	'SRHC'=>'http://localhost:82/HJ/curl/srhc.json',	
	//'SRHH'=>'http://localhost:82/HJ/curl/srhh.json',
	//新竹縣市公車路線/**/
	
	
	
	
	
	
	//http://ptx.transportdata.tw/MOTC/v2/Bus/Route/InterCity/YilanCounty?$format=json//國道客運
	
	//"HCSTOP"=>"http://ptx.transportdata.tw/MOTC/v2/Bus/Stop/City/HsinchuCounty?$format=JSON",
	//"RHCSTOP"=>'http://ptx.transportdata.tw/MOTC/v2/Bus/Route/City/HsinchuCounty?$format=json',
	//http://ptx.transportdata.tw/MOTC/v2/Bus/Shape/City/Hsinchu?$format=json
	//'RHCSTOP'=>'http://ptx.transportdata.tw/MOTC/v2/Bus/StopOfRoute/City/HsinchuCounty?$format=json',
	//'RHCSTOP'=>'http://localhost:82/HJ/curl/srhc.json',
	//'RHCSTOP'=>'http://localhost:82/HJ/curl/rhc.json',
);
echo "<hr>";
	foreach($NCDRURL as $key=>$url){
		echo "$url<hr>";
		ob_flush();//強迫輸出
		flush();
		$array=getJSON($url);
		//var_dump($array);		
		
		toDB($key,$array,$link);//接續處理各別的資料到db
		echo "$url is ok!!<Br>";
		echo "<hr><br>";
	}
//==========





function toDB($key,$jsondata,$link){//寫入db  
	switch($key){	
		//旅館
		case "SSHT":
			$query="truncate table od_SSHT";
			mysql_query($query,$link) or die('Errant query:  '.$query);
			echo "$query<br>";
			foreach($jsondata as $row){
			$field="";$val="";			
				foreach ($row as $k=>$v){					
					if (is_array($v)){ //下層
						foreach ($v as $k1=>$v1){
							$field .="$k1,";
							$val .="'".htmlspecialchars(str_replace("\\","/",$v1),ENT_QUOTES)."',";
									}
						}else{ //當層	
							$field .="$k,";
							$val .="'".htmlspecialchars(str_replace("\\","/",$v),ENT_QUOTES)."',";
					}
				}
				$field=substr($field,0,-1);	
				$query ="INSERT INTO od_SSHT (". $field.',cd) values ('.$val.'NOW())';
				//echo $query."<br>";
				ob_flush();//強迫輸出
				flush();
				$result = mysql_query($query,$link) or die('Errant query:  '.$query);
			echo "<hr>";
			}
					
		break;
		case "SCHT":
			$query="truncate table od_SCHT";
			mysql_query($query,$link) or die('Errant query:  '.$query);
			echo "$query<br>";			
			foreach($jsondata["Table"] as $row){
			$field="";$val="";			
				foreach ($row as $k=>$v){					
					if (is_array($v)){ //下層
						foreach ($v as $k1=>$v1){
							$field .="$k1,";
							$val .="'".htmlspecialchars(str_replace("\\","/",$v1),ENT_QUOTES)."',";											
									}
						}else{ //當層	
							$field .="$k,";
							$val .="'".htmlspecialchars(str_replace("\\","/",$v),ENT_QUOTES)."',";
					}
				}
						
				$field=substr($field,0,-1);				//$val=substr($val,0,-1);
				$query ="INSERT INTO od_SCHT (". $field.',cd) values ('.$val.'NOW())';
				ob_flush();//強迫輸出
				flush();
				$result = mysql_query($query,$link) or die('Errant query:  '.$query);
			echo "<hr>";
			}					
		break;
		
	
		
		//公車站
		case "HCSTOP":	
			//clear
			$query="truncate table od_bsstop";
			mysql_query($query,$link) or die('Errant query:  '.$query);
			echo "$query<br>";
		case "HHSTOP":
			foreach($jsondata as $row){
				$field="";
				$val="";			
				foreach ($row as $k=>$v){					
					if (is_array($v)){ //下層
						foreach ($v as $k1=>$v1){
						$field .="$k1,";
						$val .="'".htmlspecialchars(str_replace("\\","/",$v1),ENT_QUOTES)."',";									
						}
					}else{ //當層	
						$field .="$k,";
						$val .="'".htmlspecialchars(str_replace("\\","/",$v),ENT_QUOTES)."',";
						
					}
				}			
				$field=substr($field,0,-1);				//$val=substr($val,0,-1);
				//$query ="INSERT INTO od_bsstop (". $field.',cd) values ('.htmlspecialchars(str_replace("\\","/",$val),ENT_QUOTES).'NOW())';//('.substr($val,0,-1).')';
				$query ="INSERT INTO od_bsstop (". $field.',cd) values ('.$val.'NOW())';
				//echo $query."<br>";
				ob_flush();//強迫輸出
				flush();
				$result = mysql_query($query,$link) or die('Errant query:  '.$query);
				echo "<hr>";
			}
			
	break;
	//路線處理
		case "RHCROT":	
			//clear
			$query="truncate table od_bsroute";
			mysql_query($query,$link) or die('Errant query:  '.$query);
			echo "$query<br>";
			$query="truncate table od_bssubroute";
			mysql_query($query,$link) or die('Errant query:  '.$query);
			echo "$query<br>";
		case "RHHROT":			
			echo "<hr>";
			foreach($jsondata as $row){
				$field="";$val="";			
				foreach ($row as $k=>$v){					
					if (is_array($v)){ //下層
						foreach ($v as $k1=>$v1){
						if ($k=="SubRoutes"){					
							$fieldx="";$valx="";
							if (is_array($v1)){ //下層
									foreach ($v1 as $k2=>$v2){
										if (is_array($v2)){ //下層
											foreach ($v2 as $k3=>$v3){
												$fieldx .="$k3,";
												$valx .="'".htmlspecialchars(str_replace("\\","/",$v3),ENT_QUOTES)."',";															
											}
										}else{ 											
											$fieldx .="$k2,";											
											$valx .="'".htmlspecialchars(str_replace("\\","/",$v2),ENT_QUOTES)."',";													
									}
								}
							}
							$fieldx=str_replace(",0,",",OperatorIDs,",$fieldx);
							$queryx= "INSERT INTO od_bssubroute ($fieldx cd ) values ($valx NOW())";
							echo "$queryx<BR>";
							ob_flush();//強迫輸出
							flush();
							$result = mysql_query($queryx,$link) or die('Errant query:  '.$queryx);
						}else{							
							
							if (is_array($v1)){ //下層
									foreach ($v1 as $k2=>$v2){
										if (is_array($v2)){ //下層
											foreach ($v2 as $k3=>$v3){											
												$field .="$k3,";												
												$val .="'".htmlspecialchars(str_replace("\\","/",$v3),ENT_QUOTES)."',";															
											}
										}else{ //當層								
											$field .="$k2,";									
											$val .="'".htmlspecialchars(str_replace("\\","/",$v2),ENT_QUOTES)."',";
										}			
									}
							}else{ //當層									
								$field .="$k1,";							
								$val .="'".htmlspecialchars(str_replace("\\","/",$v1),ENT_QUOTES)."',";							
							}
						}						
						}
					}else{ //當層						
						$field .="$k,";
						$val .="'".htmlspecialchars(str_replace("\\","/",$v),ENT_QUOTES)."',";						
					}
				}
				//echo "<br>";
				$field=substr($field,0,-1);				//$val=substr($val,0,-1);
				$field=str_replace(",0,",",OperatorIDs,",$field);
				$query ="INSERT INTO od_bsroute (". $field.',cd) values ('.$val.'NOW())';
				echo $query."<br>";
				ob_flush();//強迫輸出
				flush();
				$result = mysql_query($query,$link) or die('Errant query:  '.$query);
				echo "<hr>";
			}
			
	break;
//路線+站牌處理
		case "SRHC":	
			//$result = mysql_query("SHOW TABLES LIKE '".$table."'",$link) or die('Errant query:  '.$query);
			//clear
			/*$table="od_bsrs";
			 ()) {
				$rows=$result->fetchAll();
				var_dump($rows);
				if( $rows== 1) {
					echo "Table exists <br>";
					$createtable=0;
				}
				ob_flush();//強迫輸出
				flush();
				
			}else {
				
				var_dump($result);
				echo "Table does not exist<br>";
				$createtable=1;
				//create table
			}*/
			
			
			$query="truncate table od_bsrs";
			mysql_query($query,$link) or die('Errant query:  '.$query);
			echo "$query<br>";
		case "SRHH":
		var_dump($jsondata);
		//ob_flush();//強迫輸出
		//flush();
				
			foreach($jsondata as $row){
				
				$RUID=$row["RouteUID"];
				$SRUID=$row["SubRouteUID"];
				foreach($row["Stops"] as $k=>$stops){
					$STUID=$stops["StopUID"];
					$SNO=$k;
					$lat=$stops["StopPosition"]["PositionLat"];
					$lng=$stops["StopPosition"]["PositionLon"];
					
					$query="INSERT INTO od_bsrs (RouteUID,SubRouteUID,StopUID,SNO,lat,lng,cd) values ('$RUID','$SRUID','$STUID','$SNO','$lat','$lng',NOW())";		
					mysql_query($query,$link) or die('Errant query:  '.$query);
				}
			/*	
				$field="";
				$val="";			
				foreach ($row as $k=>$v){					
					if (is_array($v)){ //下層
						foreach ($v as $k1=>$v1){
						if (is_array($v1)){ //下層
								foreach ($v1 as $k2=>$v2){
									if (is_array($v2)){ //下層
										foreach ($v2 as $k3=>$v3){
											//if ($k3==0){
											//	$field .="$k2,";
											//}else{
												$field .="$k3,";
											//}
													//$field .="$k3,";
											$val .="'".htmlspecialchars(str_replace("\\","/",$v3),ENT_QUOTES)."',";															
										}
									}else{ //當層
										//if ($k2==0){
										//	$field .="$k1,";
										//}else{
											$field .="$k2,";
										//}									
										//$field .="$k2,";
										$val .="'".htmlspecialchars(str_replace("\\","/",$v2),ENT_QUOTES)."',";
									}//echo " $k1=>$v1 ,";				
								}
						}else{ //當層	
							//if ($k1==0){
							//	$field .="$k,";
							//}else{
								$field .="$k1,";
							//}
							$val .="'".htmlspecialchars(str_replace("\\","/",$v1),ENT_QUOTES)."',";
							//echo " $k=>$v ,";
						}
								
						}
					}else{ //當層						
						$field .="$k,";
						$val .="'".htmlspecialchars(str_replace("\\","/",$v),ENT_QUOTES)."',";
						//echo " $k=>$v ,";
					}
				}
				//echo "<br>";
				$field=substr($field,0,-1);				//$val=substr($val,0,-1);
				if ($createtable==1){
					//create_field();
					$createtable=0;
				}
				$query ="INSERT INTO od_bsrs (". $field.',cd) values ('.$val.'NOW())';
				//echo $query."<br>";
				ob_flush();//強迫輸出
				flush();
				$result = mysql_query($query,$link) or die('Errant query:  '.$query);
				echo "<hr>";*/
			}
			
	break;
	
	case "SSCF": //景點
			$query="truncate table od_sscf";
			mysql_query($query,$link) or die('Errant query:  '.$query);
			foreach($jsondata["XML_Head"]["Infos"]["Info"] as $row){	
			$field=implode( ',', array_keys($row));		
			$val="";	
			foreach ($row as $k=>$v){
				$v=is_array($v)?$v=implode(',',$v):$v;
				$val .="'".htmlspecialchars(str_replace("\\","/",$v),ENT_QUOTES)."',";			
			}
			$query ="INSERT INTO od_sscf (". str_replace('Add,','`Add`,',$field).',cd) values ('.$val.'NOW())';//('.substr($val,0,-1).')';
			ob_flush();//強迫輸出
			flush();
			$result = mysql_query($query,$link) or die('Errant query:  '.$query);		
			}	
	break;
	case "SSAF": //活動		
			$query="truncate table od_SSAF";
			mysql_query($query,$link) or die('Errant query:  '.$query);
			foreach($jsondata["XML_Head"]["Infos"]["Info"] as $row){	
			$field=implode( ',', array_keys($row));		
			$val="";	
			foreach ($row as $k=>$v){
				$v=is_array($v)?$v=implode(',',$v):$v;
				$val .="'".htmlspecialchars(str_replace("\\","/",$v),ENT_QUOTES)."',";			
			}
			$query ="INSERT INTO od_SSAF (". str_replace('Add,','`Add`,',$field).',cd) values ('.$val.'NOW())';//('.substr($val,0,-1).')';
			ob_flush();//強迫輸出
			flush();
			$result = mysql_query($query,$link) or die('Errant query:  '.$query);		
			}	
	break;
	case "SSRF": //餐飲	
			$query="truncate table od_SSRF";
			mysql_query($query,$link) or die('Errant query:  '.$query);
			foreach($jsondata["XML_Head"]["Infos"]["Info"] as $row){	
			$field=implode( ',', array_keys($row));		
			$val="";	
			foreach ($row as $k=>$v){
				$v=is_array($v)?$v=implode(',',$v):$v;
				$val .="'".htmlspecialchars(str_replace("\\","/",$v),ENT_QUOTES)."',";			
			}
			$query ="INSERT INTO od_SSRF (". str_replace('Add,','`Add`,',$field).',cd) values ('.$val.'NOW())';//('.substr($val,0,-1).')';
			ob_flush();//強迫輸出
			flush();
			$result = mysql_query($query,$link) or die('Errant query:  '.$query);		
			}	
	break;	
	}
}



function getJSON($url){//取得來源並將 XML 或JSON 統一為JSON 格式輸出	
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url ); 
	//是ssl
	//echo strtoupper($url)."<br>";
	if (substr(strtoupper($url),0,8)=="HTTPS://"){
		//echo "HTTPS <br>";
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	}/**/
	curl_setopt($ch, CURLOPT_HEADER,0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	
	$postResult = trim(curl_exec($ch)); 
	$postResult=str_replace('{ "', '{"', $postResult);
	if (curl_errno($ch)) {
		echo "error!!<Br>";
	   print curl_error($ch);	
	} 
	curl_close($ch);
	//$postResult=htmlspecialchars($postResult,ENT_QUOTES);
	//var_dump($postResult);//取回
	//xml的處理
	//echo strtoupper($postResult)."<br>";
	//if ($url=="http://cand.moi.gov.tw/of/ap/cand2_json.jsp?electkind=0700000"){
	//	echo substr($postResult,0,6)."<br>";
	//}
	//echo '{"=>'.substr($postResult,3,2) ."==>". substr($postResult,0,1) ;
	$postResult=preg_replace("/^\xef\xbb\xbf/", '', $postResult); //移除BOM<==這個大資料時會死,所以list 不做
	
	if (substr(strtoupper($postResult),0,6)=="<?XML "){
		echo " is xml <br>";
	$xml = simplexml_load_string($postResult);
	$json = json_encode($xml);
	$array = json_decode($json,TRUE);
	}elseif (substr($postResult,0,2) =='{"' or substr($postResult,0,1) =='[' or substr($postResult,3,2) =='{"' ){
		echo " is JSON <br>";
		//$array=$postResult;
		//$json = json_encode($postResult);
			
		//$postResult=preg_replace("/^\xef\xbb\xbf/", '', $postResult); //移除BOM<==這個大資料時會死,所以list 不做
		//echo "json to array!<Br>";		
		//ob_flush();//強迫輸出
		//flush();
		$array = json_decode($postResult,TRUE); /* 因為List 筆數太多所以死掉了 */		
		echo "<hr>";
		
		echo "error:".json_last_error()."<Br>";
		echo "error msg:".json_last_error_msg()."<Br>";
		
		ob_flush();//強迫輸出
		flush();
				
	}else{
		//csv的處理		
		if (substr($postResult,0,6)=='存取'){
			echo "url 404<br>";
			$array=array();
		}else{
		echo " is csv or OTHER Format!! -" . substr($postResult,0,10)."<br>";
		$postResult=iconv("big5","UTF-8",$postResult);
		$array = array_map("str_getcsv", explode("\n", $postResult));
		$json = json_encode($array);
		$array = json_decode($json,TRUE);
		}
	}
	return $array;//只取內容
}
/*
//show field
function GetTableFields($tablename){
	$field=array();
	$result = mysql_query("SHOW COLUMNS FROM $tablename");
	if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}
	if (mysql_num_rows($result) > 0) {
		while ($row = mysql_fetch_assoc($result)) {
			$field[]=implode( ' , ', $row );
				if ((strpos($row["Type"],'varchar')==0) or (strpos($row["Type"],'text')==0)){ 				
					$query="UPDATE $tablename SET ".$row["Field"]." = REPLACE(".$row["Field"].', \'台\', \'臺\');'; //<==sql error
					echo $row["Type"]." run update filter -- $query <br>";
				}			
		}
	}
	return $field;
}
}*/
?>