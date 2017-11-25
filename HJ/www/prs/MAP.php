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

		//旅館 *還沒
		$query="SELECT sno,id,name,py,px,`Add` FROM od_ssrf where bus=0 and `Add` like '%新竹%'";
		//echo "$query<br>";
		$res=MDB2_query($mdb2 ,$query);
		$rows=$res->fetchAll();
		//var_dump($rows);
		$template->assign('SSHF',$rows);//Category('qatype',$mdb2));//下拉選單








		/*	
	$query="SELECT sno,id,name,py,px FROM od_ssaf where bus=0 and `Add` like '%新竹%'";
		//echo "$query<br>";
		$res=MDB2_query($mdb2 ,$query);
		$rows=$res->fetchAll();
		var_dump($rows);
		$template->assign('SSAF',$rows);//Category('qatype',$mdb2));//下拉選單
	*/	
		
		
		
		
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