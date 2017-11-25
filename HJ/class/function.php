<?php
header("Content-Type:text/html; charset=utf-8");
//===mdb2 function ======
/*列出 function */
//include toolsfun.php;

//====db control=====================
function MDB2_connect($DB_DNS){ 
	$mdb2 =&MDB2::connect($DB_DNS);
	$mdb2->exec('set names utf8');
	if (PEAR::isError($mdb2)) {
		die($mdb2->getMessage());  //change to log file
    		return "error";
	}else{
		return $mdb2;
	}
}

function MDB2_query($mdb2,$query){	
	if ($query=="" or empty($query)){
		echo "<a style='color:red'> error: Query string is null !!</a><br>";
		exit;
	}
		
	$res =$mdb2->query($query);
	if (PEAR::isError($res)) {
		//echo $res->getMessage();		
			//=====error message to log file==================
			$content = date("Y-m-d H:i:s")."  sql => ".$query."<Br>".$res->getMessage()."<br>";
			$fp = fopen("mysql-query-error.log","a+");//"wb");
			fwrite($fp,$content);
			fclose($fp);
			
	}else{
		return $res;
	}
	
}
//=====login=======
//檢查帳號密碼,並傳回資訊
function Check_ID_PWD($ACC,$PWD,$PJ,$mdb2){
	//先看是否為管理員身份
	/*$query ="select id,acc,spec,power from sys_acc where acc='$ACC' AND pwd='$PWD' and POWER >=90"; //管理者的身分
	$res=MDB2_query($mdb2 ,$query);	
	$pl=$res->fetchRow();
	*/
	//if (empty($pl)){//限制專案身分
	$query="select acc, id,  spec,  disable,power from sys_acc  where acc='$ACC' AND pwd='$PWD'  and end_day >= now() ";
	//}else{//管理員不受管制=>取得管理者資料,及直接寫入到user,後續要以session內的為參考,不能直接抓db*/		
	//	$query="select '$ACC' as acc, '".$pl[0]."' as id,'".$PJ."' as P_ID, name, '".$pl[2]."' as spec, fax, tel, 'n' as disable,zip,addr ,'".$pl[3]."' as power from sys_prj where id='$PJ'";
	//}
	//echo $query."<br>";
	$res=MDB2_query($mdb2 ,$query);	
	$rows=$res->fetchRow();
	return  $rows;
}

//記錄登入時間及使用者ip
function ENTERLOG($uid,$mdb2){	
	if (!empty($_SERVER['HTTP_CLIENT_IP']))	{
	  $ip=$_SERVER['HTTP_CLIENT_IP'];
	}else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))	{
			  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
			}else{
			  $ip=$_SERVER['REMOTE_ADDR'];
			}
			//'".date('Y-m-d H:i:s'). "'
	$query="update sys_acc set log=NOW(),ip='$ip' where id='$uid' ";
	$res=MDB2_query($mdb2 ,$query);	
	$query="insert into sys_acc_log (acc,p_id,ip) values('".$acc_info[0]."','".$acc_info[2]."','$ip') ";	
	$res=MDB2_query($mdb2 ,$query);
	//return  $ip;
}

//追蹤使用者行為
function FollowUp($uid,$mdb2){	
	if (!empty($_SERVER['REQUEST_URI']))	{
		$link=explode("?",$_SERVER['REQUEST_URI']);
		//echo $link[0]."<br>";
		//減量(壓縮)
		if (strtoupper($link[0])=='/LEVIS_ADMIN/WWW/INDEX.PHP'){ //"strtoupper('/Levis_admin/www/index.php'))
			$link[0]='-';
		}
		//當 $link[0]='-' and $link[1]='' <==首頁 是否要寫???
		$query="insert into click_log (url,parameter,session_id,member_id) values('".$link[0]."','".$link[1]."','".session_id()."','".$uid."') ";	
		$res=MDB2_query($mdb2 ,$query);
	}
}
//目錄列表
function EditMenu($mid,$mdb2,$level=0){ //選項的資料內容,注意預設路徑值
	//請先定義好前後台及共用("NULL",)
	$query="select type,id,title,target,css,icon,p_id,url,file_path,sno,power,BMODEL,display from menu where up_id='$mid' and display in ('2','1','3') order by sno asc";
	$level++;
	$res=MDB2_query($mdb2 ,$query);	
	$rows=$res->fetchAll();

	foreach($rows as $k=> $row){
		//1:display,2.後台Only,0:不使用之功能
		switch($row[12]){
			case 0://不可能,因為Hidden
			break;
			case 1://前後台
				$v_icon=EDISPLAY."  ".EDISPLAY;
			break;
			case 2://後台Only
				$v_icon=NDISPLAY."  ".EDISPLAY;
			break;
			case 3://前台Only
				$v_icon=EDISPLAY."  ".NDISPLAY;//.' <a style="color:green;font-size:80%">Only</a>';
			break;
		};
		
		$html .="<tr ><td><input type='checkbox' id='".$row[1]."' /></td><td>". $v_icon."</td><td>".str_repeat('&nbsp;', $level * 4). $row[5]." ".$row[2]."</td><td>".Menufunbar($row[1],$level,"MET")."</td></tr>";
		$html .=EditMenu($row[1],$mdb2,$level);		
	}	
	return $html;	
}
function Menufunbar($id,$level,$mode){
	$html= '<a href="?mode='.$mode.'&fun=a&num='.$id.'"><i class="fa fa-plus-circle" ></i></a>&nbsp;&nbsp;&nbsp;&nbsp; '.
		   '<a href="?mode='.$mode.'&fun=e&num='. $id .'"><i class="fa fa-edit" ></i></a>&nbsp;&nbsp;&nbsp;&nbsp; '.
			'<a id="dnum'. $id .'" alt="'. $id .'"><i class="fa fa-times-circle" ></i></a>&nbsp;&nbsp;&nbsp;&nbsp; </td><td>';
			
	if ($level > 1){
		$html .='<a id="lnum'. $id .'" alt="'. $id .'"><i class="fa fa-chevron-circle-left" ></i></a>&nbsp;&nbsp;&nbsp;&nbsp; ';
	}else{
		$html .=str_repeat('&nbsp;', 7);//'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';
	}		
	
	
	$html .='<a id="upnum'. $id .'" alt="'. $id .'"><i class="fa fa-arrow-circle-o-up" ></i></a>&nbsp;&nbsp;&nbsp;&nbsp; '.
			'<a id="dwnum'. $id .'" alt="'. $id .'"><i class="fa fa-arrow-circle-o-down" ></i></a>&nbsp;&nbsp;&nbsp;&nbsp; ';
	return $html;	
}
//產品目錄列表
function EditPMenu($mid,$mdb2,$level=0){ //選項的資料內容,注意預設路徑值
	//請先定義好前後台及共用("NULL",)
	$query="select type,id,title,target,css,icon,display from menu_products where up_id='$mid' order by SNO asc";
	//echo "$query<br>";
	$level++;
	$res=MDB2_query($mdb2 ,$query);	
	$rows=$res->fetchAll();

	foreach($rows as $k=> $row){
		//1:display,2.後台Only,0:不使用之功能
		switch($row[6]){
			case 0://Hidden
				$v_icon=NDISPLAY;
			break;
			case 1://SHOW
				$v_icon=EDISPLAY;
			break;
			
		};		
		$html .="<tr ><td><input type='checkbox' id='".$row[1]."' /></td><td>". $v_icon."</td><td>".str_repeat('&nbsp;', $level * 4). $row[5]." ".$row[2]."</td><td>".Menufunbar($row[1],$level,"PMET")."</td></tr>";
		$html .=EditPMenu($row[1],$mdb2,$level);		
	}	
	return $html;	
}
function GetWebMenu($mdb2){
	$query="select type,id,title,target,css,icon,p_id,url,file_path,sno,power,BMODEL from  menu where up_id='0' and display in ('4') and localhost is null order by sno asc";
	//echo "$query<br>";
	$res=MDB2_query($mdb2 ,$query);	
	$rows=$res->fetchAll();
	return $rows;
}
function GetWebfooterMenu($mdb2){
	$query="select type,id,title,target,css,icon,p_id,url,file_path,sno,power,BMODEL from  menu where up_id='0' and display in ('4')  and localhost='FOT' order by sno asc";
	//echo "$query<br>";
	$res=MDB2_query($mdb2 ,$query);	
	$rows=$res->fetchAll();
	return $rows;
}
//取得權限選單
function GetMenu($POWER,$mid,$mdb2){ //選項的資料內容,注意預設路徑值
	//請先定義好前後台及共用("NULL",)
	$query="select type,id,title,target,css,icon,p_id,url,file_path,sno,power,BMODEL from  menu where up_id='$mid' and display in ('2','1') and power <='$POWER' order by sno asc";
	//echo "$query<br>";
	$res=MDB2_query($mdb2 ,$query);	
	$rows=$res->fetchAll();

	switch ($mid){
		case '0':
			$html='<ul class="nav" id="side-menu" >';
		break;
		default:
			$html='<ul class="nav nav-second-level">';
		break;
	}

	foreach($rows as $k=> $row){
		$html .="<li ><a ";
		switch ($row[0]){
			case 'D':				
				//if (!empty($row[3]))
				//	$html .=" target='".$row[3]."' "; 				

				if (!empty($row[4]))
					$html .=" class='".$row[4]."' "; 				
				
				$html .=" >".$row[5]." ".$row[2]." <span class='fa arrow'></span></a>";				
			break;
			case 'C':
				if (!empty($row[3]))
					$html .=' target="'.$row[3].'" '; 				

				if (!empty($row[4]))
					$html .=' class="'.$row[4].'" '; 				
				
				$html .=' href="?mode=CTX&id='.$row[1].'" ';
				$html .=" >".$row[5]." ".$row[2]."</a>";
				
			break;
			case 'M':
				if (!empty($row[3]))
					$html .=' target="'.$row[3].'" '; 				

				if (!empty($row[4]))
					$html .=' class="'.$row[4].'" '; 				
				
				$html .=' href="?mode='.$row[11].'" ';
				$html .=" >".$row[5]." ".$row[2]."</a>";
			break;
			case 'U':
				//if (!empty($row[3]))
					//$html .=' target="'.$row[3].'" '; 				

				if (!empty($row[4]))
					$html .=' class="'.$row[4].'" '; 				
				
				$html .=' href="?mode=OUTLINK&url='.$row[7].'&tg='.$row[3].'" ';
				$html .=" >".$row[5]." ".$row[2]."</a>";
			break;
			case 'F':
				//if (!empty($row[3]))
					//$html .=' target="'.$row[3].'" '; 				

				if (!empty($row[4]))
					$html .=' class="'.$row[4].'" '; 				
				
				$html .=' href="?mode=OUTLINK&url='.$row[8].'&tg='.$row[3].'"';
				$html .=" >".$row[5]." ".$row[2]."</a>";
			break;
		}
		$rt=GetMenu($POWER,$row[1],$mdb2);
		//echo "rt:$rt<br>";
		if ($rt <>'<ul class="nav nav-second-level">'){
			$html.=$rt."</li>\n</ul>\n";
		}else{
			$html.="</li>\n";
		}
	}	
	return $html;	
}
//取得權限選單
function GetPRDMenu($mid,$mdb2){ //選項的資料內容,注意預設路徑值
//1找出這層的所有項目
	$query="select id,title,css,icon from  menu_products where up_id='$mid'  order by sno asc";
	//echo "$query<br>";
	$res=MDB2_query($mdb2 ,$query);	
	$rows=$res->fetchAll();	
	$RT=$rows;
	foreach($rows as $k=>$row){
		$sub=GetPRDMenu($row[0],$mdb2);
		if (!empty($sub)){
				array_push($RT[$k],$sub);
		}		
	}
	return $RT;
}

//使用功能選項時,會有定義好的內容頁面,處理方式如下
function GetPageInfo($POWER,$MODEL,$id,$mdb2){
	switch ($MODEL){
		case "DSL":
			$query="select title,type,id,target,css,icon,p_id,url,file_path,sno,power,'DSL' as bmodel,control from menu where id='$id' and type='D' and power <= '$POWER' order by sno asc ";
		break;
		case "CTX":
			$query="select title,type,id,target,css,icon,p_id,url,file_path,sno,power,'CTX' as bmodel,control from menu where id='$id' and type='C' and power <= '$POWER'  order by sno asc ";
		break;
		default:
			$query="select title,type,id,target,css,icon,p_id,url,file_path,sno,power,bmodel,control from menu where bmodel='$MODEL' and power <= '$POWER' order by sno asc ";		
		break;
	}
	//echo "$query";
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();
	return $rows;
}


//ajax無法正常轉址(轉址前已有輸出)// if output_buffering disable headr function is not work
function header_c($url,$msg=''){
	//var_dump(ini_get('output_buffering'));
	/*if (ini_get('output_buffering')==''){
		 echo "<Script> window.location = '".$url."';</script>";
	}else{*/
		//header('Location: '.$url.'');
		
		echo "<script>";
		if ($msg!='')
		   echo " alert('".$msg."');";
		echo " window.location.replace('".$url."');</script>";
	//}
    //ini_set('output_buffering', 'on');

}

function Category($form_type,$mdb2){	
	$query="select title,val,id from sys_category where form_type='$form_type' and enable='Y' order by sno asc";	
	$res=MDB2_query($mdb2 ,$query);
	return $res->fetchAll();
}

//upload image	
function UploadImg($tmp,$target_dir){	
	$target_file = $target_dir . basename($tmp["name"]);
	if (move_uploaded_file($tmp['tmp_name'], $target_file)) {
		//	echo "File is valid, and was successfully uploaded.\n";
	} else {
		echo "Possible file upload attack!\n";
		echo "<br>$target_file<br>";
	}	
}
/*
function UserInfo($mdb2,$sno){//$ouid,
	$query="select a.id as acc, ou_id, ouname, power, spec, SPEC1, email, tel, disable, upou,orgname "
	."from sys_acc as a "
	."left join sys_ou as u on a.ou_id=u.id "
	."left join sys_org as o on u.org_id=o.id where a.sno='$sno'";
	
	$res=MDB2_query($mdb2 ,$query);	
	$rows=$res->fetchRow();
	return  $rows;
}*/

/*
//以id取得單位名稱
function GetOUNAME($OUID,$mdb2){
	$query="select ouname from sys_ou where id='$OUID' ";
	$res=MDB2_query($mdb2,$query);
	$rows=$res->fetchRow();	
	return $rows[0];
}
*/
function SQLInsert($query,$types,$data){
	$mdb2 = MDB2_connect(DB_DNS);//資料庫連線	
	$sth = $mdb2->prepare($query, $types, MDB2_PREPARE_MANIP); //'INSERT INTO numbers VALUES (?, ?, ?)'		
	$rows = $sth->execute($data);	
	$sth->free();
	$mdb2->disconnect();
}

//======寫入系統log==============
function SYSLOG1($mdb2){
	$context="<ul>";
	foreach ($_POST as $key => $value)
		 $context .= '<li>'.$key.'='.$value.'</li>';
	
	if ($context=='<ul>'){
		$context="";
	}else{	
		$context .="</ul>";
	}
	$sys_account=$_SESSION[sys][usid];
	$url=$_SESSION[sys][url];
	$datex=date('Y-m-d H:i:s');
	$query="INSERT INTO syslog (l_url ,l_context , l_action , h_datetime ) VALUES ('$url','$context','$sys_account','$datex')" ;	
	$res = MDB2_query($mdb2,$query);
	//$rows=$res->fetchAll();
	//return 0;
}
/*//改用Jquery datatable元件取代了
//===========SET PAGER======
function SET_PAGER($path,$perPage,$dbquery){
	$params = array(
	'mode' => 'Sliding',//分頁模式
	'perPage' => $perPage,//一頁幾筆
	'path' => $path,//產生分頁的頁面
	//'fileName' =>'javascript:HTML_AJAX.replace(\'target\',\'index.php?pageid=7&entrant=%d\');',
//	'fileName' => $fileName,//自訂分頁傳遞的參數
//	'append' => false,//取消參數自動傳遞，這樣才能自訂fileName的參數
	'append' => true,//參數自動傳遞
	//'urlVar' => 'entrant',//自訂傳回變數
	'delta' => 5,//幾頁分段
	'useSessions'=> true ,//disable
	'httpMethod'=> 'POST',
	'httpMethod'=> 'GET',
	'itemData' => $dbquery//資料來源是上方的資料庫查詢結果
	);
	return $params;
}
//smarty由陣列0開始所以次頁會空白-所以要加上以下處理		
function ChangArrayFrom0($MyArray){
	$i=0;
	foreach ($MyArray as  $value){
		$fdata[$i]=$value;
		$i++;
	}
	return $fdata;
}*/			
//=====sql inject======
function quotes($content)
{
	//如果magic_quotes_gpc=Off，那?就開始處理
	if (!get_magic_quotes_gpc()) {
		//判斷$content是否?陣列
		if (is_array($content)) {
		//如果$content是陣列，那?就處理它的每一個單無
			foreach ($content as $key=>$value) {
				
				if (strpos($key,"xajax")!=false){ //開放如果是xajax的值,就不check
					$content[$key] = addslashes($value);
					$content[$key] = htmlentities($content[$key],ENT_QUOTES);
				}
				//$content[$key] = addslashes($value);
				//$content[$key] = htmlentities($content[$key],ENT_QUOTES); 			
				}
		} else {
		$content=addslashes($content);	//如果$content不是陣列，那?就僅處理一次	
		$content = htmlentities($content,ENT_QUOTES);		
		}
	} else {
		//如果magic_quotes_gpc=On，那?就不處理addslashes
		//判斷$content是否?陣列
		if (is_array($content)) {		
			foreach ($content as $key=>$value) {//如果$content是陣列，那?就處理它的每一個單無
				$content[$key] = htmlentities($content[$key],ENT_QUOTES); 			
			}
		} else {			
		$content = htmlentities($content,ENT_QUOTES);//如果$content不是陣列，那?就僅處理一次		
		}
	}
	return $content;
}
 //HTML特殊字元轉換  <==反向轉換htmlentities
function Uhtmlentities($str_1){
	$prt=str_replace('&#039;',"'",$str_1);
	$prt=str_replace('&quot;','"',$prt);
	$prt=str_replace('&amp;','&',$prt);	
	$prt=str_replace('&lt;',"<",$prt);
	$prt=str_replace('&gt;',">",$prt);
	//$prt=$str_1;
	return $prt;
}
//================================================================
/*
function findtop($mdb2,$id){	
	$query="select upid,name,pageid from headbar where pageid='".$id."' order by pageid asc " ;	
	$res = MDB2_query($mdb2,$query);
	$rows=$res->fetchAll();
	if ($rows[0][0] <> -1){
	     $itemtop=findtop($mdb2,$rows[0][0]);
	 }else{
		 $itemtop=$rows;
	 }
	return $itemtop;
}

//=======================================
function wpath($mdb2,$id){	
  $wlist[] = findwpath($mdb2,$id);
  $i=0;  
  while ($wlist[$i][0][0] <> -1){
	 $wlist[] = findwpath($mdb2,$wlist[$i][0][0]);  
	$i++;
  }
  return $wlist;
}

function findwpath($mdb2,$id){	
	$query="select upid,name,pageid from headbar where pageid='".$id."'  order by pageid asc " ;	
	$res = MDB2_query($mdb2,$query);
	return $res->fetchAll();	
}
*/
//=============導覽功能==================

/*****************導覽路徑標示（Breadcrumbs）*************************/
function Breadcrumbs_tools($mdb2,$id,$sing = ">"){ //要處理最後一個 $sing	
	$regx = '/'.preg_quote('>il/< '.$sing, '/').'/';
	//echo $regx."<Br>";
	$to='>il/< ';
    return '<li> <A style="color:white;letter-spacing:1px;font-size:1px;" href="#" accesskey="C">:::</a><a href="?mode=dhb"  ><i class="fa fa-home fw"></i> Home</a> '.$sing.' </li>' .strrev(preg_replace($regx, $to, strrev(Breadcrumbs($mdb2,$id,$sing)), 1));	
}
//網站導覽列
function Breadcrumbs($mdb2,$id,$sing){
		$query="select up_id,title,type,bmodel,icon from menu where id='".$id."'" ;	
		$res = MDB2_query($mdb2,$query);
		$rows=$res->fetchRow();
		if(!empty($rows) ){
			
			switch($rows[2]){
				case "M":					
					$context='<a href="?mode='.$rows[3].'" >'.$rows[4]." ".$rows[1]."</a>";
				break;
				case "C":				
					$context='<a href="?mode=CTX&id='.$id.'" >'.$rows[4]." ".$rows[1]."</a>";
				break;				
				default:/*U,F不會到這來*/				
				case "D":
					$context='<a href="?mode=DSL&id='.$id.'" >'.$rows[4]." ".$rows[1]."</a>";
				break;
			}
			 $RT = '<li>'.$context." $sing </li>";
			 
			 if ($rows[0]>0)
				$RT = Breadcrumbs($mdb2,$rows[0],$sing).$RT;//找上一層
		}
		return $RT;
}

/*****************產品導覽路徑標示（Breadcrumbs）*************************/
function Products_Breadcrumbs_tools($mdb2,$id,$sing = ">"){ //要處理最後一個 $sing	
	$regx = '/'.preg_quote('>il/< '.$sing, '/').'/';
	//echo $regx."<Br>";
	$to='>il/< ';
    return '<li> <A style="color:white;letter-spacing:1px;font-size:1px;" href="#" accesskey="C">:::</a> 所在階層 : </li>' .strrev(preg_replace($regx, $to, strrev(Products_Breadcrumbs($mdb2,$id,$sing)), 1));	
}
//網站導覽列
function Products_Breadcrumbs($mdb2,$id,$sing){
		$query="select up_id,title,type,icon from menu_Products where id='".$id."'" ;	
		$res = MDB2_query($mdb2,$query);
		$rows=$res->fetchRow();
	//	echo "$query<br>";
	//	var_dump($rows);
		if(!empty($rows) ){
			
			switch($rows[2]){
				case "M":					
					$context='<a href="?mode=PRD&ID='.$id.'" >'.$rows[3]." ".$rows[1]."</a>";
				break;
				default:
				case "D":
					$context='<a href="?mode=PRD&ID='.$id.'" >'.$rows[3]." ".$rows[1]."</a>";
				break;
			}
			 $RT = '<li>'.$context." $sing </li>";
			 
			 if ($rows[0]>0)
				$RT = Products_Breadcrumbs($mdb2,$rows[0],$sing).$RT;//找上一層
		}
		return $RT;
}

/**===========傳送 mail=================*
  function Sendmail($from,$subject,$text,$html,$sendto,$file=""){    
	  //==附加檔案==  $file = '/home/appleboy/adwii/AB2.jpg'; 
	  $param['text_charset'] = 'utf-8';
	  $param['html_charset'] = 'utf-8';
	  $param['head_charset'] = 'utf-8';
	  $hdrs = array(
					'From'    => $from,
					'Subject' => $subject,
					'Content-type' => 'text/plain; charset=utf-8'
					);
	  $crlf = "\n";				
	  $mime = new Mail_mime($crlf);//1.使用 Mail_mime() 建立新的 Mail_mime 物件(constructor)。
	  //2.至少要使用 setTXTBody(), setHTMLBody(), addHTMLImage() 或 addAttachment()四者其中之一建立內文或附檔。（當然通常的情況不只使用一個囉）
	  $mime->setTXTBody($text);
	  $mime->setHTMLBody($html);
	  $mime->addAttachment($file, 'text/plain', 'AB2.jpg');//附加檔案
	  $body = $mime->get($param);//3.使用 get() 傳回內文。
	  $hdrs = $mime->headers($hdrs);//4.使用 headers() 傳回檔頭。
	  $mail =& Mail::factory('mail');//5.利用傳回的內文與檔頭丟給 Mail::send() 送信。
	  $mail->send($sendto, $hdrs, $body);
  }
  function addAttachment($file,
                           $c_type      = 'application/octet-stream',
                           $name        = '',
                            $isfile     = true,
                           $encoding    = 'base64',
                           $disposition = 'attachment',
                           $charset     = '',
                            $language   = '',
                           $location    = '')	
  */
 //=================load sys info to session==================
 function LoadSYSINFOtoSession(){
 $mydefine=(get_defined_constants(true)); //輸出所有常數
 //print_r($mydefine."<br>");
	 foreach ($mydefine as $key => $value){
	// print_r ($key."<br>");	
		if ($key=="user"){
			foreach ($value as $key1=>$value1){
				if ($key1=='PEAR_ERROR_RETURN'){
				break;	}else{	
					$_SESSION["USER"]["$key1"]=$value1;	}			  
			}
		}			
	}		
 }
 function SLoadSYSINFOtoSession(){
	$mydefine=(get_defined_constants(true)); //輸出所有常數
	foreach ($mydefine as $key => $value){
	if ($key=="user"){
		foreach ($value as $key1=>$value1){
			print_r($key1.":".$value1 ."<br>");
		}	
	}
 }		
 }
 /*
 function SPAW($mdb2,$query,$template,$opname,$itemarray){
 	$res = MDB2_query($mdb2,$query);
	$rows=$res->fetchAll();	
	// 轉回 " ' < > 的值
	$prt=Uhtmlentities($rows[0][0]);
	//$prt=$rows[0][0];
	$template->assign('SPAW',$prt);
	
	//$template->assign('SPAW',$rows[0][0]);
	$template->assign('update',$rows[0][1]);
	$MAINIT=array($opname,"mode=$_GET[mode]");
	$template->assign('MAINIT',$MAINIT);	
	$IT=$_GET[item]-1;
	if ($IT < 0 )
	$IT=0;
	//$template->assign('OPNAME',$itemarray[$IT][0]);
 }*/
 

	
function checkid($mdb2,$n,$p){
	$query="select count(sno) from sys_account where power > 0  and pwd='$p' and id='$n'";	
	$res = MDB2_query($mdb2,$query);
	$rows=$res->fetchRow();		
	if ($rows[0]==1){
		return $n;
	}else{
		return null;
	}
}

function POWER($mdb2,$n,$p){
	$query="select power from sys_account where power > 0  and pwd='$p' and id='$n'";	
	$res = MDB2_query($mdb2,$query);
	$rows=$res->fetchRow();		
	if (is_null($rows[0])){
		return null;
	}else{
		return $rows[0];
	}
}

//字串中是否包含特定字元
function checkin($os,$header){ 
       if (str_replace($os,"",$header)==$header){                
		return 0 ;        
	   }else{ 
		return 1;
	   }
}
//*****************功能部分**************************
//取得來源IP
function GET_IP(){
if (empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
		$myip = $_SERVER['REMOTE_ADDR'];
    } else {
		$myip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
		$myip = $myip[0];
	}
return $myip;
}
/*e-mail發送通知機制*/
function SendMailToG($e_mail, $subject,$content,$ATTC=""){
	$mail= new PHPMailer(); //建立新物件    
	$mail->SMTPDebug = SMTPDEBUG; 
    $mail->Mailer = 'smtp';
	$mail->IsSMTP(); //設定使用SMTP方式寄信  	
	$mail->SMTPAuth = true; //設定SMTP需要驗證 
	$mail->Username = MACC; //設定驗證帳號        
	$mail->Password = MPWD; //設定驗證密碼      

	$mail->SMTPSecure = "ssl"; // Gmail的SMTP主機需要使用SSL連線   
	$mail->Host = "smtp.gmail.com"; //Gamil的SMTP主機        
	$mail->Port = 465;  //Gamil的SMTP主機的SMTP埠位為465埠。        
	$mail->CharSet = "utf8"; //設定郵件編碼        
	//$mail->WordWrap = 50;	//每50行斷一次行
	if (trim($ATTC)!=""){
		$mail->AddAttachment($ATTC);// 附加檔案
	}	
	$mail->From = DFROM; //設定寄件者信箱        
	$mail->FromName = DNAME; //設定寄件者姓名 
	
	$mail->Subject = trim($subject); //設定郵件標題        

	$mail->Body = $content;
	//設定郵件內容  
	
	$mail->IsHTML(true); //設定郵件內容為HTML 
	foreach ($email as $v){//都是陣列
			$mail->AddAddress($v[0], $v[1]); //設定收件者郵件及名稱
			$html.= "<br>mail=>$v[0]   ($v[1])";
		}
	if(!$mail->Send()) {        
 		$msg="<BR>發送異常!! Mailer Error: " . $mail->ErrorInfo."  ".$e_mail;  
	} else { 
		$msg="<BR>已發送email 如下:<br>";     	   
	}   
	return $msg.$html;	
}
//推通知到android手機上
function push_to_android($msg){ 
		// API access key from Google API's Console
	define( 'API_ACCESS_KEY', 'YOUR-API-ACCESS-KEY-GOES-HERE' );
	$registrationIds = array( $_GET['id'] );
	// prep the bundle
	$msg = array
	(
		'message' 	=> 'here is a message. message',
		'title'		=> 'This is a title. title',
		'subtitle'	=> 'This is a subtitle. subtitle',
		'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
		'vibrate'	=> 1,
		'sound'		=> 1,
		'largeIcon'	=> 'large_icon',
		'smallIcon'	=> 'small_icon'
	);
	$fields = array
	(
		'registration_ids' 	=> $registrationIds,
		'data'			=> $msg
	);
	 
	$headers = array
	(
		'Authorization: key=' . API_ACCESS_KEY,
		'Content-Type: application/json'
	);
	 
	$ch = curl_init();
	curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
	curl_setopt( $ch,CURLOPT_POST, true );
	curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	$result = curl_exec($ch );
	curl_close( $ch );
	return $result;
	
}

//計數器
function Counter($FilePath){ //"counter.txt"	
	$myip=GET_IP();	
	if ($myip==$_SESSION['user']['ip']){	
		return str_pad($_SESSION['sys']['counter'],8,'0',STR_PAD_LEFT);//補0;
	}else{
	//file_get_content ($FilePath,$counter);
	//$counter += 1;
	//file_put_content ($FilePath,$counter);	
	$fp= fopen($FilePath,"r+");
	//由檔案讀取計數器值,並將其值加1
	$counter= fgets($fp,80);
	$counter= doubleval ($counter) + 1;
	//將檔案指位器(pointer)指回初始位置,並寫入計數器值
	fseek($fp,0);
	fputs($fp,$counter);
	fclose($fp);//關閉檔案
	$_SESSION['user']['ip']=$myip;
	$_SESSION['sys']['counter']=$counter;
	return str_pad($counter,8,'0',STR_PAD_LEFT);//補0
	}
};
//全形半形字轉換 
function nf_to_wf($strs, $types){  
$nft = array(
		"(", ")", "[", "]", "{", "}", ".", ",", ";", ":",
        "-", "?", "!", "@", "#", "$", "%", "&", "|", "\\",
        "/", "+", "=", "*", "~", "`", "'", "\"", "<", ">",
        "^", "_",
        "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j",
        "k", "l", "m", "n", "o", "p", "q", "r", "s", "t",
        "u", "v", "w", "x", "y", "z",
        "A", "B", "C", "D", "E", "F", "G", "H", "I", "J",
        "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T",
        "U", "V", "W", "X", "Y", "Z",
        " "
    );
    $wft = array(
        "（", "）", "〔", "〕", "｛", "｝", "﹒", "，", "；", "：",
        "－", "？", "！", "＠", "＃", "＄", "％", "＆", "｜", "＼",
        "／", "＋", "＝", "＊", "～", "、", "、", "＂", "＜", "＞",
        "︿", "＿",
        "０", "１", "２", "３", "４", "５", "６", "７", "８", "９",
        "ａ", "ｂ", "ｃ", "ｄ", "ｅ", "ｆ", "ｇ", "ｈ", "ｉ", "ｊ",
        "ｋ", "ｌ", "ｍ", "ｎ", "ｏ", "ｐ", "ｑ", "ｒ", "ｓ", "ｔ",
        "ｕ", "ｖ", "ｗ", "ｘ", "ｙ", "ｚ",
        "Ａ", "Ｂ", "Ｃ", "Ｄ", "Ｅ", "Ｆ", "Ｇ", "Ｈ", "Ｉ", "Ｊ",
        "Ｋ", "Ｌ", "Ｍ", "Ｎ", "Ｏ", "Ｐ", "Ｑ", "Ｒ", "Ｓ", "Ｔ",
        "Ｕ", "Ｖ", "Ｗ", "Ｘ", "Ｙ", "Ｚ",
        "　"
    );
 
    if ($types == '1'){
        // 轉全形
        $strtmp = str_replace($nft, $wft, $strs);
    }else{
        // 轉半形
        $strtmp = str_replace($wft, $nft, $strs);
    }
    return $strtmp;
}
//產生QRCode

function printQRCode($url, $size = 100) {
    return '<img src="http://chart.apis.google.com/chart?chs=' . $size . 'x' . $size . '&cht=qr&chl=' . urlencode($url) . '" />';
}

//地址查座標
function geoCode($address,$Gkey){
	/*在此範例中，Google Maps Geocoding API 會要求針對 "1600 Amphitheatre Parkway, Mountain View, CA" 查詢傳回 json 回應。*/
	$url="https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&key=".$Gkey;
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//ssl
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
	
	$output = json_decode(curl_exec($ch),true);
 	curl_close($ch);
	return $output;		
}


?>