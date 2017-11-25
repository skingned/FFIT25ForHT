<?php 
	@session_start();
		header("Content-Type:text/html; charset=utf-8"); 
		include_once ("../include.php");
		$_POST=quotes($_POST);
		$_GET=quotes($_GET);		
		$mdb2 = MDB2_connect(DB_DNS);//資料庫連線
		//下拉選項
		$template->assign('WEBTYPE',Category('webtype',$mdb2));//分類
		$template->assign('WEBSTATE',Category('webstate',$mdb2));//分類
		$template->assign('BUDGET',Category('budget',$mdb2));
		$template->assign('MAINTAIN',Category('maintain',$mdb2));
		$template->assign('QATYPE',Category('qatype',$mdb2));	
		
		$query="select id,title,type,target,context,url,img_path,SNO,SD,ED,en from slider where en='1' and NOW() > SD AND  NOW() < ED order by sno asc";
		$res=MDB2_query($mdb2 ,$query);
		$rows=$res->fetchAll();	
		//$template->assign('SLIDER_INFO',$rows);	//頁面資料
		
?>