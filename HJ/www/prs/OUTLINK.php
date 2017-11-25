<?php 
@session_start();
//把對外連的URL當參數存下來
	$mdb2 = MDB2_connect(DB_DNS);//資料庫連線
	//var_dump($_GET);	
	if (!empty($_GET) && !empty($_GET["url"])){
		if ($_GET["url"]=='login.php'){	
			$template->assign('SCRIPT','window.location ="login.php";');//登出 不用計
		}else{
			if (!empty($_SERVER['REQUEST_URI']))	{
			$link=explode("?",$_SERVER['REQUEST_URI']);
			//echo $link[0]."<br>";
			//減量(壓縮)
			/*if (strtoupper($link[0])=='/LEVIS_ADMIN/WWW/INDEX.PHP'){ //"strtoupper('/Levis_admin/www/index.php'))
				$link[0]='-';
			}*/
			//寫log
			$query="insert into click_log (url,parameter,session_id,member_id) values('".$link[0]."','".$link[1]."','".session_id()."','".$_SESSION['USR']['ID']."') ";	
			$res=MDB2_query($mdb2 ,$query);
			//count (即時)
			//$query="insert into click_log (url,parameter,session_id,member_id) values('".$link[0]."','".$link[1]."','".session_id()."','".$_SESSION['USR']['ID']."') ";	
			//$res=MDB2_query($mdb2 ,$query);
			}
			$URL=str_replace('"',"",$_GET["url"]);		
			//$template->assign('URL',$URL);//轉走
			if ($_GET["tg"]!='_blank'){ //另開新視窗
					$template->assign('SCRIPT','window.location ="'.$URL.'";');
			}else{
				$template->assign('SCRIPT','window.open("'.$URL.'");');	
			}		
		}
	}	
?>
