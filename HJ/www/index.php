<?php 
@session_start();

$PRVURL=$_SESSION['SYS']['url'];//存上頁url
$_SESSION['SYS']['url']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];//記下目前url
include_once ("../include.php");
//增加一些限制來做展示前的保護
if (false){
$_SESSION["DEMO"]=empty($_SESSION["DEMO"])?$_GET["DEMO"]:$_SESSION["DEMO"];
if ($_SESSION["DEMO"] !="SKING"){
	$_SESSION["DEMO"]=null;
	if (date("Y-m-d H") !="2017-06-21 13"){
		header_c('no.php','尚未開放');	
		exit;
	}
}
}

//no login pass ,Redirection to login
//var_dump($_SESSION);
/*if ( $_SESSION['SYS']['err']!="0") //登入異常,回登入頁面
	header_c('login.php',NOLOGIN);*/
//==sql injection=====
/*$_SESSION['USR']['ID']=0; //使用者代碼號
$_SESSION['USR']['POWER']=0; //權限*/

$_POST=quotes($_POST);
$_GET=quotes($_GET);
//-------樣版檔參數設定------------
$template= new Template(); //
//$template->cache_lifetime=300;//快取時間
$template->assign('SYSNAME',PRG_NAME);
$template->assign('COMPANY',COMPANY);
$template->assign('COMPANYFULL',COMPANYFULL);
$template->assign('COMPANYADDR',COMPANYADDR);
$template->assign('MAPKEY',MAPKEY);
/*
$_SESSION['PJ']['MENU']=GetMenu($_SESSION['USR']['POWER'],0,$mdb2);//單位
*/
//$_SESSION['PJ']['MENU']=;//單位
$mdb2=MDB2_connect(DB_DNS);
//$template->assign('MENU',GetMenu($_SESSION['USR']['POWER'],0,$mdb2));//功能選單
//var_dump(GetWebMenu($mdb2));
$template->assign('MENU',GetWebMenu($mdb2));//功能選單
//var_dump(GetWebfooterMenu($mdb2));
$template->assign('FOOTERMENU',GetWebfooterMenu($mdb2));
/*
if(empty($_GET[mode])){
	include 'prs/HOME.php';
}*/

//追蹤及分析
FollowUp($_SESSION['USR']['ID'],$mdb2);

//====引入子樣版檔=========
//$leftpage="leftbar.tpl.htm";
//$subname="sub/p1.tpl.htm";	
//==========mode=============
if (DEBUGMOD == 1){
	$template->debugging =true;
	print_r("POST:<br>");
	print_r($_POST);
	print_r("GET:<br>");
	print_r($_GET);
	print_r("SESSION:<br>");
	print_r($_SESSION);
	print_r("<br>");
}
			
//----headbar info--------------------------------------
/*----設定路徑----*/
	/*$IT=$_GET[item]-1;
	if ($IT < 0 )
		$IT=0;
	$template->assign('OPNAME',$itemarray[$IT][0]);*/
/*--------------------*/	

//=====subpage init========

$_CONTROL=array(1,1,1,1);//title,fbar,table,dtl
$_FBAR=array(1,1,1,1);//預設功能介面打開// array('查詢','新增','刪除','修改'); 修改在table中/**/
//====預設的樣版====
$_FBAR_PATH="../tpl/element/fbar.tpl.htm";
$_TABLE_PATH="../tpl/element/table.tpl.htm";
$template->assign('ACTION','?mode='.$_GET[mode]);//指定form的action 預設傳回給自已來做處理
//if (empty($_GET[mode]))//{			//default page;
		$_GET[mode]=empty($_GET[mode])?"MAP":$_GET[mode];//default page;
		$main_tpl="index.tpl.htm";
		//$main_tpl=($_GET[mode]=="MAP")?"index.tpl.htm":"main.tpl.htm";//預設首頁樣版
//===================
		$_GET[mode]=strtoupper($_GET[mode]);
		$GetInfo=GetPageInfo(10,$_GET[mode],$_GET[id], MDB2_connect(DB_DNS));//驗證為模組,並取出名稱   
		//var_dump($GetInfo);
		$_GET[mode]=$GetInfo[11];
		$_SUBTITLE=$GetInfo[0];
		$_CONTROL=split(',',$GetInfo[12]);
		$template->assign('Breadcrumbs',Breadcrumbs_tools(MDB2_connect(DB_DNS),$GetInfo[2],'>'));//導覽路徑標示（Breadcrumbs）
	   
	   if (!empty($_SUBTITLE)){
		   $template->assign('MODE_NAME',$_GET[mode]);//存下來當參數用
		
		switch(strtoupper($_GET[mode])){
			/*作業*/
			default://標準的
					//使用xajax	
					include 'ajax/ajx_'.$_GET[mode].'.php';				
					$template->assign('jsscript', $xajax->getJavascript('../js/xajax_core'));	
					
					include 'prs/'.$_GET[mode].'.php';	
					$subname='sub/'.$_GET[mode].'.tpl.htm';
					//echo $subname;	
			break;
			case "MAP1":
					//使用xajax	
					//var_dump('MAP');
					include 'ajax/ajx_'.$_GET[mode].'.php';				
					$template->assign('jsscript', $xajax->getJavascript('../js/xajax_core'));					
					include 'prs/'.$_GET[mode].'.php';	
					$subname='sub/'.$_GET[mode].'.tpl.htm';
			break;
			//======特別定義			
			case "CTX":		//靜態頁面
				$_CONTROL=array(1,0,0,1);//title,fbar,table,dtl
				include "prs/CONTENT.php";
				$subname="element/CONTENT.tpl.htm";
			break;
			case "DSL":		//目錄頁面
				$_CONTROL=array(1,0,0,1);//title,fbar,table,dtl
				include "prs/DLS.php";	
				$subname="element/DLS.tpl.htm";
			break;
			case "OUTLINK":		//對外連結
				//header('Location: '.$PRVURL);//回上頁
				//$_CONTROL=array(1,0,0,1);//title,fbar,table,dtl
				include "prs/OUTLINK.php";	
				$subname="sub/OUTLINK.tpl.htm";
			break;


	}	 
	}else{
		//to error page
		echo " MODE=". $_GET['MODE']."<BR>";
		$_SUBTITLE="輸入的網頁出現錯誤";
		$context='找不到您要的資訊，請 <a href="/">回首頁</a> ';
		
		$template->assign('CONTENT',$context);		
		$subname="element/error.tpl.htm";
	}	 

	$template->assign('SUBNAME',$_SUBTITLE);
	$template->assign('FBAR', $_FBAR);
 	$template->assign('FBAR_PATH', $_FBAR_PATH);
	$template->assign('TABLE_PATH', $_TABLE_PATH);
	$template->assign('CONTROL', $_CONTROL);
//=====================
	$template->assign('OKBTN', OKBTN);
	$template->assign('NGBTN', NGBTN);
	$template->assign('VIEWBTN', VIEWBTN);
	$template->assign('DELBTN', DELBTN);
	/*載入作業樣版*/	
	$template->assign('SUBTPL',TPL_PATH . $subname);
	/*載入主樣版*/	
	$template->display(TPL_PATH.$main_tpl);/*----------主樣版----------------*/	
	
	if (TRCDATA==1){
		/* FOR DEBUG check 填報上傳的資料問題,產生log*/	
			if (empty($mdb2))
				$mdb2 = MDB2_connect(DB_DNS);//資料庫連線
			
			$queryi = "insert into fur_log (POST_DATA,FILES_DATA,SQL_DATA,USER) "
					 ." values ('".addslashes(json_encode($_POST,true))."','".addslashes(json_encode($_FILES))."','".addslashes($query)."','".$_SESSION['USR']['UID']."')"; 	
			$res=MDB2_query($mdb2 ,$queryi);
	}
	
	
	//include "../debug_tools/parameter.PHP";
	// close connection
	//$mdb2->disconnect();
?>