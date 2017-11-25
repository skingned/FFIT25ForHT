<?php 
	@session_start();
		header("Content-Type:text/html; charset=utf-8"); 
		include_once ("../include.php");
		$_POST=quotes($_POST);
		$_GET=quotes($_GET);		
		$mdb2 = MDB2_connect(DB_DNS);//資料庫連線

		//沒有任何公車站的景點
		$query="SELECT sno,id,name,py,px,`Add` FROM od_sscf where bus=0 and `Add` like '%新竹%'";
		$res=MDB2_query($mdb2 ,$query);
		$rows=$res->fetchAll();
		$template->assign('SSCF',$rows);//Category('qatype',$mdb2));//下拉選單
		//餐廳
		$query="SELECT sno,id,name,py,px,`Add` FROM od_ssrf where bus=0 and `Add` like '%新竹%'";
		//echo "$query<br>";
		$res=MDB2_query($mdb2 ,$query);
		$rows=$res->fetchAll();
		//var_dump($rows);
		$template->assign('SSRF',$rows);//Category('qatype',$mdb2));//下拉選單

		//旅館 
		//$query="SELECT sno,id,name,py,px,`Add` FROM od_ssrf where bus=0 and `Add` like '%新竹%'";
			$MySql_query.=" select sno,F1 as id,`旅館名稱` as name,lng  ,lat ,`地址` as addr FROM od_scht where bus=0 "; 
			$MySql_query.=" union select sno,`序號` as id,`旅館名稱` as name,`緯度` as lat,`經度` as lng,`營業地址` as addr FROM od_ssht  where bus=0 "; 
		//	echo $MySql_query;
		$res=MDB2_query($mdb2 ,$MySql_query);
		$rows=$res->fetchAll();		
		$template->assign('SSHF',$rows);//Category('qatype',$mdb2));//下拉選單

//站牌景點的排名			
		$query="select a.n ,b.Zh_tw from (select count(id) as n , StopUIDs FROM od_sscf where StopUIDs in (SELECT DISTINCT StopUID FROM `od_bsstop` ) and `Add` like '%新竹%' group by StopUIDs ) as a 
		left join od_bsstop as b on a.StopUIDs=b.StopUID order by a.n desc";
		//echo "$query<br>";
		$res=MDB2_query($mdb2 ,$query);
		$rows=$res->fetchAll();
		//var_dump($rows);
		$template->assign('SSST',$rows);//Category('qatype',$mdb2));//下拉選單
		
//站牌餐廳的排名		
		$query="select a.n ,b.Zh_tw from (select count(id) as n , StopUIDs FROM od_ssrf where StopUIDs in (SELECT DISTINCT StopUID FROM `od_bsstop` ) and `Add` like '%新竹%' group by StopUIDs ) as a 
		left join od_bsstop as b on a.StopUIDs=b.StopUID order by a.n desc";
		//echo "$query<br>";
		$res=MDB2_query($mdb2 ,$query);
		$rows=$res->fetchAll();
		//var_dump($rows);
		$template->assign('SSSR',$rows);//Category('qatype',$mdb2));//下拉選單
		
/*//站牌景點的排名
		$query="select a.n ,b.Zh_tw from (select count(id) as n , StopUIDs FROM od_sscf where StopUIDs in (SELECT DISTINCT StopUID FROM `od_bsstop` ) and `Add` like '%新竹%' group by StopUIDs ) as a 
		left join od_bsstop as b on a.StopUIDs=b.StopUID order by a.n desc";
		//echo "$query<br>";
		$res=MDB2_query($mdb2 ,$query);
		$rows=$res->fetchAll();
		//var_dump($rows);
		$template->assign('SSST',$rows);//Category('qatype',$mdb2));//下拉選單*/

		
	/**/	
	
		//下拉選項
		/*$template->assign('WEBTYPE',Category('webtype',$mdb2));//分類
		$template->assign('WEBSTATE',Category('webstate',$mdb2));//分類
		$template->assign('BUDGET',Category('budget',$mdb2));
		$template->assign('MAINTAIN',Category('maintain',$mdb2));
		$template->assign('QATYPE',Category('qatype',$mdb2));	
		
		$query="select id,title,type,target,context,url,img_path,SNO,SD,ED,en from slider where en='1' and NOW() > SD AND  NOW() < ED order by sno asc";
		$res=MDB2_query($mdb2 ,$query);
		$rows=$res->fetchAll();	
		*/
		//$template->assign('SLIDER_INFO',$rows);	//頁面資料
		
?>