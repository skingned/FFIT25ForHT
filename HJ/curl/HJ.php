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
	"HCSTOP"=>"http://localhost:82/HJ/curl/hc.json",//http://ptx.transportdata.tw/MOTC/v2/Bus/Stop/City/Hsinchu?$format=json
	'HHSTOP'=>'http://localhost:82/HJ/curl/hh.json',//http://ptx.transportdata.tw/MOTC/v2/Bus/Stop/City/HsinchuCounty?$format=json

	//景點 - 觀光資訊資料庫
	'SSCF'=>'http://gis.taiwan.net.tw/XMLReleaseALL_public/scenic_spot_C_f.json',
	//活動 - 觀光資訊資料庫
	'SSAF'=>'http://gis.taiwan.net.tw/XMLReleaseALL_public/activity_C_f.json',
	//餐飲 - 觀光資訊資料庫
	'SSRF'=>'http://gis.taiwan.net.tw/XMLReleaseALL_public/restaurant_C_f.json',
	//餐飲 - 觀光資訊資料庫
	'SSRF'=>'http://gis.taiwan.net.tw/XMLReleaseALL_public/restaurant_C_f.json',
	//新竹縣市公車路線
	'RHCROT'=>'http://localhost:82/HJ/curl/rhc.json',//http://ptx.transportdata.tw/MOTC/v2/Bus/Stop/City/HsinchuCounty?$format=json
	'RHHROT'=>'http://localhost:82/HJ/curl/rhh.json',//http://ptx.transportdata.tw/MOTC/v2/Bus/Stop/City/Hsinchu?$format=json
	//新竹縣市公車路線+站牌	
	'SRHC'=>'http://localhost:82/HJ/curl/srhc.json',	
	'SRHH'=>'http://localhost:82/HJ/curl/srhh.json',
	//iTaiwan中央行政機關室內公共區域免費無線上網熱點查詢服務
	'wifi'=>'http://www.gsp.gov.tw/iTaiwan/itw_tw.json',
	//歷史交通事故資料
"DG105A1"=>"https://quality.data.gov.tw/dq_download_json.php?nid=12197&md5_url=4b9a807d3da56458974bdc91a05e3845",
"DG105A2"=>"https://quality.data.gov.tw/dq_download_json.php?nid=12197&md5_url=be765b74c179d7b7dffba3ac2291d0f0",
"DG104A1"=>"https://quality.data.gov.tw/dq_download_json.php?nid=12197&md5_url=2a5e80165964747f57106e9498d5ee6c",
"DG104A2"=>"https://quality.data.gov.tw/dq_download_json.php?nid=12197&md5_url=d0e461d73d3fa8400aad8bf1c8e589d4",
"DG103A1"=>"https://quality.data.gov.tw/dq_download_json.php?nid=12197&md5_url=e71637aa778e1368c76ef21a02f03f30",
"DG103A2"=>"https://quality.data.gov.tw/dq_download_json.php?nid=12197&md5_url=bde273c75c9e7d658511f9f96079629e",
//新竹市觀光景點清單
"HHPP"=>"http://opendata.hccg.gov.tw/dataset/07caf18a-a966-4409-810a-ce3fdb7447b7/resource/3bca2d3b-177c-4e4a-9576-4a3ed8c81612/download/20171027140854018.json",
//新竹市易塞車時段路段資訊
"CAR"=>"http://opendata.hccg.gov.tw/dataset/f0c56fdf-41c1-4c4e-803b-73715aefcd9d/resource/b20c5ca2-aeaf-4862-b885-21f8b98511c7/download/20150311103256885.json",
//新竹市公廁地點資訊
"HHTT"=>"http://opendata.hccg.gov.tw/dataset/ef9a757d-0951-47f6-9233-8542e61cb362/resource/c2dd7409-8c79-4482-9f03-c44794f7d740/download/20150303164450940.json",
//新竹市旅遊服務中心與借問站據點
"HHTC"=>"http://opendata.hccg.gov.tw/dataset/503af41c-9ccf-4820-b0a1-417ff9f6315c/resource/ed344f5f-90a0-449a-8835-56f728585857/download/20171030145042295.json",
//新竹市歷屆十大伴手禮(無座標)
"HHPC"=>"http://opendata.hccg.gov.tw/dataset/32d40161-8d8f-4da4-8a44-09f14b480c33/resource/22c99566-c9a2-469d-9178-3893d8605cdc/download/20161213191900678.json",
//新竹市市區公車運量
	"BUSR"=>"http://opendata.hccg.gov.tw/dataset/6888403a-11ad-48a2-9089-67d7de379dc0/resource/7b09e368-1de2-42bb-b397-3a481d7534de/download/20150312102410834.json",
	
*/		
	//=====================尚未處理==================================
	//http://ptx.transportdata.tw/MOTC/v2/Bus/Route/InterCity/YilanCounty?$format=json//國道客運
	//國道客運 站牌
	//"IHCSTOP"=>'http://localhost:82/HJ/curl/IHCSTOP.json', //'http://ptx.transportdata.tw/MOTC/v2/Bus/Stop/InterCity/HsinchuCounty?$format=json',
	//"IHHSTOP"=>'http://localhost:82/HJ/curl/IHHSTOP.json', //'http://ptx.transportdata.tw/MOTC/v2/Bus/Stop/InterCity/Hsinchu?$format=json',

	//國道客運 公車路線+站牌	
	//"ISRH"=>'http://localhost:82/HJ/curl/ISRH.json',    //'http://ptx.transportdata.tw/MOTC/v2/Bus/StopOfRoute/InterCity?$format=json',
	//國道客運 公車路線
	"IRHROT"=>'http://localhost:82/HJ/curl/IRHROT.json',  //http://ptx.transportdata.tw/MOTC/v2/Bus/Route/InterCity?$format=json//國道客運
	
	//公車
/*	"B01"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/8cf7e832-7344-43c6-94e6-07e424e4c43b/download/20161123133747680.json",//世博3號
	"B02"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/05d6c14a-4e41-4ca0-b8c1-da9e721a28a4/download/20150312103831211.json",//2
	"B03"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/edae215a-b399-46af-968a-e695c1d96859/download/20150312105202368.json",//71
	"B04"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/e0a00069-3e97-4784-bae6-0c7c55338ba9/download/20150312104528399.json",//23
	"B05"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/1ad7ff0b-ecfa-445a-a41c-2032c6c266b6/download/20150312105009540.json",//55
	"B06"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/9f3c9b74-3770-4e0a-819c-856551e3759f/download/20150312104612415.json",//27
	"B07"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/85e72738-3a81-4c71-ab69-b8a7d1416e21/download/20150312103932305.json",//10
	"B08"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/66d82d4b-2568-4479-bedb-4478384f2aa9/download/20150312110049135.json",//世博5號
	"B09"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/12f1abc7-f90b-499d-82b2-b0a01a484984/download/20150312104859384.json",//52
	"B10"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/4a7febc0-0e97-48f3-9ffe-202f4dc8d794/download/20150312104010164.json",//11甲
	//http://opendata.hccg.gov.tw/dataset/traffic-20150310-155251-9100
	
	"B11"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/b3ec1e28-af9c-4069-b2bc-ce5319216fa6/download/20150312105240822.json",//72
	"B12"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/246c1d04-87d5-447d-a621-f430e70a6225/download/20150312104648555.json",//31
	"B13"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/528ecc53-92df-44fb-842a-d07e9bf9ad89/download/20150312104111930.json",//11
	"B14"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/24de94b7-6356-4d72-82a8-bac6b9bf0938/download/20150312104727868.json",//50	
	"B15"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/8035bd60-e46f-4ef5-8c35-65ba455ba730/download/20150312105045915.json",//57
	"B16"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/fd1638d5-17f4-4487-9af8-8d01953587b2/download/20150312104811305.json",//51
	"B17"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/791144c3-2e34-4503-a1f4-ac7b726d8df3/download/20150312104354446.json",//16
	"B18"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/18667cdd-4712-4ca4-856e-40aa5d8b3018/download/20150312104215211.json",//12
	
	"B19"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/e38e9949-c020-4796-94fa-c40f7d469985/download/20150312105319009.json",//73
	"B20"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/94f6f333-e0b4-4d12-9e49-891178105f68/download/20150312104304211.json",//15
	"B21"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/04f465a8-066c-4298-b546-50db0cd830b9/download/20150312103318116.json",//1
	"B22"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/383e2143-ca99-41a8-9cc8-6d0277408472/download/20150312105840916.json",//世博1號
	"B23"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/97b6fe09-28c6-4a18-8e62-4ca0c430c9ef/download/20150312104934040.json",//53
	"B24"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/14bd23bb-fa1e-46ea-a0ed-df4cab1e4dcb/download/20150312104440493.json",//20
	"B25"=>"http://opendata.hccg.gov.tw/dataset/3b137260-88f3-4e20-8062-4368dbcdcb46/resource/fff140d8-23ac-4377-9322-6e8e328e8420/download/20150312105747619.json",//81
*/	

	
	/*
	//庇護工場
	"hhbf"=>"http://opendata.hccg.gov.tw/dataset/6b5ebe3e-e8ae-430a-b7ba-0d963e351c0a/resource/88ee70ed-4be0-4c52-b8e9-5d4cfcb8d578/download/20150303101423919.json",
	//新竹市台灣工藝之家
	"hhch"=>"http://opendata.hccg.gov.tw/dataset/747c6837-4a49-4730-8c10-8d1967031038/resource/7abab3ff-4099-4e47-a021-e8aaf557c952/download/20170907181259743.json",
	//觀光工廠
	"hhfs"=>"http://opendata.hccg.gov.tw/dataset/0cbe8db2-bd99-4b7d-84ff-51b375b6458b/resource/91beb3c3-b4b0-45b1-98b3-92554c8613bd/download/20160226113813795.json",
	//新竹市古蹟一覽表
	"hhod"=>"http://opendata.hccg.gov.tw/dataset/7ea7e303-df62-4fbe-a84f-99bdd724b577/resource/c15a9c5f-f6cb-4da5-b8a6-5e7bc4c9eb08/download/20170713153035510.json",
	//新竹市綠色商店資訊
	"hhgn"=>"http://opendata.hccg.gov.tw/dataset/8e32f19d-b4c4-4cf9-b5af-26e0dd604b99/resource/b8177aff-ad5e-43d5-8f3a-c79240013a88/download/20170809162413028.json",
	//新竹市環保旅店資訊
	"hhgh"=>"http://opendata.hccg.gov.tw/dataset/38aad14e-052a-4f07-b9a9-c4cca6b01658/resource/3bc694c4-2ecb-48b3-85bd-e05381e0fc59/download/20170809162142669.json",
	//新竹市公共自行車租賃系統(YouBike)
	"hhybk"=>"http://opendata.hccg.gov.tw/dataset/1f334249-9b55-4c42-aec1-5a8a8b5e07ca/resource/4d5edb22-a15e-4097-8635-8e32f7db601a/download/20171116115229668.json",*/
);
echo "<hr>";
	foreach($NCDRURL as $key=>$url){
		echo "$url<hr>";
		ob_flush();//強迫輸出
		flush();
		$array=getJSON($url);
		toDB($key,$array,$link);//接續處理各別的資料到db
		echo "$url is ok!!<Br>";
		echo "<hr><br>";
		//各別處理
		switch($key){
			case "hhgh"://新竹市旅店
				$query="update `od_hhgh` as a, `od_ssht` as b 
					set green=1 
					where a.`飯店名稱`=b.`旅館名稱`";
				mysql_query($query,$link) or die('Errant query:  '.$query);
				echo "附加=>環保旅店資訊:$query<br>";	
			break;
		//以下為0的都是要加到 od_sscf 中
		
			case "hhch"://台灣工藝之家
				$query= "update od_hhch as a ,od_sscf as b
					  set in_org=1 
					  where  a.`工作室名稱`=b.Name and b.`Add` like '%新竹%'";
				mysql_query($query,$link) or die('Errant query:  '.$query);
				echo "附加台灣工藝之家=>重覆景點 :$query<br>";					
				/*
				//為0的還沒有加到景點中;
				$query ="INSERT INTO od_sscf (Name,`Add`,.....)
						select `工作室名稱`,`地址`,.... from od_hhch where in_org=0";				
				echo "加入到景點=>".$query."<br>";
				mysql_query($query,$link) or die('Errant query:  '.$query);				
				*/
			break;
			
			case "hhfs"://新竹市觀光工廠
				$query= "update od_hhfs as a ,od_sscf as b
					  set in_org=1 
					  where  a.`工廠名稱`=b.Name and b.`Add` like '%新竹%'";
				mysql_query($query,$link) or die('Errant query:  '.$query);
				echo "附加觀光工廠=>重覆景點 :$query<br>";	
				//為0的還沒有加到景點中;
			break;
			case "HHPP"://新竹市景點 重覆		 
				$query= "update od_HHPP as a ,od_sscf as b
					  set in_org=1 
					  where  a.`景點名稱`=b.Name and b.`Add` like '%新竹%'";
				mysql_query($query,$link) or die('Errant query:  '.$query);
				echo "附加新竹市景點=>重覆景點 :$query<br>";	
				//為0的還沒有加到景點中;
			break;
			case "hhod"://新竹市古蹟 重覆		 
				$query= "update od_hhod as a ,od_sscf as b
					  set in_org=1 
					  where  a.`古蹟名稱`=b.Name and b.`Add` like '%新竹%'";
				mysql_query($query,$link) or die('Errant query:  '.$query);
				echo "附加新竹市古蹟=>重覆景點 :$query<br>";	
				//為0的還沒有加到景點中;
			break;

		}
	}
//==========


function LoadData($table,$jsondata,$link,$d=1){			
			$create_f=0;
			if ($d==1){
			$query="truncate table $table";
			mysql_query($query,$link); //or die('Errant query:  '.$query);
			if (!$result) {
					//echo 'Errant query:  '.$query;
					$create_f=1;
			}
			echo "$query<br>";
			}
			foreach($jsondata as $row){
			$field="";$val="";			
				foreach ($row as $k=>$v){					
					if (is_array($v)){ //下層
						foreach ($v as $k1=>$v1){
							$field .="`$k1`,";
							$val .="'".htmlspecialchars(str_replace("\\","/",$v1),ENT_QUOTES)."',";
									}
						}else{ //當層	
							$field .="`$k`,";
							$val .="'".htmlspecialchars(str_replace("\\","/",$v),ENT_QUOTES)."',";
					}
				}
				$field=substr($field,0,-1);		
				$query ="INSERT INTO $table (". $field.',cd) values ('.$val.'NOW())';
				echo $query."<br>";
				ob_flush();//強迫輸出
				flush();
				$result = mysql_query($query,$link);// or die('Errant query:  '.$query);
				if (!$result) {					
					if($create_f){
						$CreateSQL="CREATE TABLE `$table` (`id` int(11) NOT NULL,";
						$f= explode(",", $field);					
						foreach($f as $v){
								$CreateSQL .= " $v varchar(100) NOT NULL,";
						}
						$CreateSQL.=" `cd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
						echo $CreateSQL."<br>";
						mysql_query($CreateSQL,$link) or die('Errant query:  '.$CreateSQL);
						$CreateSQL =" ALTER TABLE `$table`  ADD UNIQUE KEY `id_2` (`id`),  ADD KEY `id` (`id`);";
						echo $CreateSQL."<br>";
						mysql_query($CreateSQL,$link) or die('Errant query:  '.$CreateSQL);
						$CreateSQL=" ALTER TABLE `$table` ADD PRIMARY KEY(`id`);";
						echo $CreateSQL."<br>";
						mysql_query($CreateSQL,$link) or die('Errant query:  '.$CreateSQL);
						$CreateSQL=" ALTER TABLE `$table`  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
						echo $CreateSQL."<br>";
						mysql_query($CreateSQL,$link) or die('Errant query:  '.$CreateSQL);
						$create_f=0;
					}else{
						echo 'Errant query:  '.$query."<Br><hr>" ;	
					}					
				}
			}
			echo "<hr>";
			return 1;
}


function toDB($key,$jsondata,$link){//寫入db  
	switch($key){
		case "hhybk"://新竹市公共自行車租賃系統
			LoadData("od_hhybk",$jsondata,$link);
		break;
		case "hhgn"://新竹市綠色商店資訊
			LoadData("od_hhgn",$jsondata,$link);
		break;
		case "hhbf"://庇護工場
			LoadData("od_hhbf",$jsondata,$link);
		break;	


		
		case "hhgh"://新竹市環保旅店資訊
			LoadData("od_hhgh",$jsondata,$link);
		break;			
		case "hhod"://新竹市古蹟一覽表
			LoadData("od_hhod",$jsondata,$link);
		break;
		case "hhfs"://觀光工廠
			LoadData("od_hhfs",$jsondata,$link);
		break;
		case "hhch"://新竹市台灣工藝之家
			LoadData("od_hhch",$jsondata,$link);
		break;

		case "B01": //新竹市公車站牌資訊
			LoadData("od_busrstop",$jsondata,$link);
		break;
		case "B02":
				LoadData("od_busrstop2",$jsondata,$link);
		break;	
		case "B03":
		case "B04":
		case "B05":
		case "B06":
		case "B07":
		case "B08":
		case "B09":
		case "B10":
		case "B11":	
		case "B12":		
		case "B13":
		case "B14":
		case "B15":
		case "B16":
		case "B17":
		case "B18":
		case "B19":
		case "B20":
		case "B22":	
		case "B22":		
		case "B23":
		case "B24":
		case "B25":
			LoadData("od_busrstop2",$jsondata,$link,0);
		break;	
		
		case "BUSR": //新竹市市區公車運量
			LoadData("od_busr",$jsondata,$link);
			//SELECT a.*,b.* FROM `od_busr` as a left join `od_bsroute` as b on b.`Zh_tw` =a.`路線別` order by b.zh_tw asc  <==線路有的沒對上,要處理 加工到同一table
		break;	
		
		case "CAR"://新竹市易塞車時段路段資訊 x
			LoadData("od_car",$jsondata,$link);
		break;	
		
		case "HHTT"://新竹市公廁地點資訊  x
			LoadData("od_hhtt",$jsondata,$link);
		break;	
		case "HHTC"://新竹市旅遊服務中心與借問站據點
			LoadData("od_hhtc",$jsondata,$link);
		break;		
		case "HHPC"://新竹市歷屆十大伴手禮
			LoadData("od_hhpc",$jsondata,$link);			
		break;		
		case "HHPP": //新竹市景點 x			
			LoadData("od_HHPP",$jsondata,$link);			
		break;				
		case "wifi"://wifi			
			LoadData("od_wifi",$jsondata,$link);			
		break;
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
			$query="truncate table od_bsrs";
			mysql_query($query,$link) or die('Errant query:  '.$query);
			echo "$query<br>";
		case "SRHH":
		//var_dump($jsondata);
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
	
			}
			
	break;
	//國道客運
		//公車站
		case "IHCSTOP":			
			//clear
			$query="truncate table od_ibsstop";
			mysql_query($query,$link) or die('Errant query:  '.$query);
			echo "$query<br>";
			
		case "IHHSTOP":
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
				$query ="INSERT INTO od_ibsstop (". $field.',cd) values ('.$val.'NOW())';
				//echo $query."<br>";
				ob_flush();//強迫輸出
				flush();
				$result = mysql_query($query,$link) or die('Errant query:  '.$query);
				echo "<hr>";
			}
		break;
	
	//=======================================================
	
	//路線處理
		case "IRHROT":	
			//clear
			$query="truncate table od_ibsroute";
			mysql_query($query,$link) or die('Errant query:  '.$query);
			echo "$query<br>";
			$query="truncate table od_ibssubroute";
			mysql_query($query,$link) or die('Errant query:  '.$query);
			echo "$query<br>";		
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
							$queryx= "INSERT INTO od_ibssubroute ($fieldx cd ) values ($valx NOW())";
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
				$query ="INSERT INTO od_ibsroute (". $field.',cd) values ('.$val.'NOW())';
				echo $query."<br>";
				ob_flush();//強迫輸出
				flush();
				$result = mysql_query($query,$link) or die('Errant query:  '.$query);
				echo "<hr>";
			}
			
	break;
//路線+站牌處理
		case "ISRH":			
			$query="truncate table od_ibsrs";
			mysql_query($query,$link) or die('Errant query:  '.$query);
			echo "$query<br>";
		
		//var_dump($jsondata);
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
					
					$query="INSERT INTO od_ibsrs (RouteUID,SubRouteUID,StopUID,SNO,lat,lng,cd) values ('$RUID','$SRUID','$STUID','$SNO','$lat','$lng',NOW())";		
					mysql_query($query,$link) or die('Errant query:  '.$query);
				}
	
			}
			
	break;
	/**/
	
	
	
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
case "DG105A1":
			
			$query="truncate table od_DG";
			mysql_query($query,$link) or die('Errant query:  '.$query);
						
			echo "$query<br>";
case "DG105A2":
case "DG104A1":
case "DG104A2":
case "DG103A1":
case "DG103A2":   //歷史交通事故資料
			$table="od_DG";			
			foreach($jsondata as $row){
			$field="";$val="";			
				foreach ($row as $k=>$v){					
					if (is_array($v)){ //下層
						foreach ($v as $k1=>$v1){
							//$field .="$k1,";
							$val .="'".htmlspecialchars(str_replace("\\","/",$v1),ENT_QUOTES)."',";
									}
						}else{ //當層	
							//$field .="$k,";
							$val .="'".htmlspecialchars(str_replace("\\","/",$v),ENT_QUOTES)."',";
					}
				}
				//$field=substr($field,0,-1);	
				$query ="INSERT INTO $table (發生時間,發生地點,死亡受傷人數,車種,cd) values (".$val.'NOW())';
				echo $query."<br>";
				ob_flush();//強迫輸出
				flush();
				$result = mysql_query($query,$link) or die('Errant query:  '.$query);
				
			}
			echo "<hr>";
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

?>