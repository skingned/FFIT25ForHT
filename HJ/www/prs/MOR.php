<?php 
	@session_start();
		header("Content-Type:text/html; charset=utf-8"); 
		include_once ("../include.php");
		$_POST=quotes($_POST);
		$_GET=quotes($_GET);		
		$mdb2 = MDB2_connect(DB_DNS);//資料庫連線
		/*$query="select * from mortgage ";
		$res=MDB2_query($mdb2 ,$query);
		$rows=$res->fetchAll();	
	
		$template->assign('MOR',$rows);	//頁面資料*/
		
		
		$head=array('機構','貸款專案','專案起迄日期','貸款金額','貸款期間','利率結構','各期利率','帳戶管理費','寬限期','清償限制方式','清償限制期間','限制對象','特殊限制','房貸指標利率','指標利率調整時間','連結網頁','其他說明','最後更新日期');//表單欄位名稱
		//$query = "select n.id,c.title,n.title,CONCAT(DATE_FORMAT(n.sd,'%Y-%m-%d'),' ~ ',DATE_FORMAT(n.ed,'%Y-%m-%d')) as life,display from www_news as n left join sys_category as c on c.id=n.category_id";
		$query ="select id,機構,貸款專案,專案起迄日期,貸款金額,貸款期間,利率結構,各期利率,帳戶管理費,寬限期,清償限制方式,清償限制期間,限制對象,特殊限制,房貸指標利率,指標利率調整時間,連結網頁,其他說明,最後更新日期 from mortgage where (ed='0000-00-00' or ed >=now()) and trim(機構) <> '網站管理者'";
		//echo $query;
		$res=MDB2_query($mdb2 ,$query);
		$rows=$res->fetchAll();	
		//var_dump($rows);
		$template->assign('HH_lst',$head);//表頭		
		$template->assign('H_lst',$rows);//內容
?>