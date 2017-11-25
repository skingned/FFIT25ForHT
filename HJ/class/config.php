<?php

define ('PRG_NAME','新竹黑客松-地方開放資料戰');
define ('COMPANY' ,"豐富科技 團隊");
//define ('ADMINNAME',"官網管理後台");
define ('COMPANYFULL' ,"豐富科技");
define ('COMPANYADDR' ,"新北市新店區建安街33巷29號1樓");


define ('DEBUGMOD' ,0);
define ('TRCDATA' ,0);//使用者資料記錄

define ('DFROM' ,'skingned6665@gmail.com');//寄件者信箱(顯示)
define ('DNAME' ,'豐富科技');//寄件者(顯示)
define ('SMTPDEBUG',0);//email debug
define ('MACC' ,"skingned6665@gmail.com");//設定驗證帳號
define ('MPWD' ,"Sking@ned");//設定驗證密碼


//*****************路徑****************************
define ('APP_REAL_PATH' ,dirname(dirname(__FILE__)));//自動取得網站路徑
//echo gethostname()."<br>";
switch (gethostname()){
	case "Sking":
		define ('DB_USER','root');
		define ('DB_PASS','!QAZ1qaz');		
		define ('MAPKEY' ,"AIzaSyBBXHUUOD1cSwsHzXcCxNLwkLLVX0PHB8I");
	break;

	default:
		define ('DB_USER','root');
		define ('DB_PASS','Vac@lulala');		
		define ('MAPKEY' ,"AIzaSyAAsffnUQ3lD6JHzKSy_Rq_qGp-BYa1qnM");
	break;
}

//====設定pear路徑===========
define ('PEAR_Path',APP_REAL_PATH."/PEAR");
ini_set("include_path",PATH_SEPARATOR.ini_get("include_path").PEAR_Path);
//===========================
define ('TPL_PATH' , "../tpl/");  //樣版路徑

//***************設定DB***********************
define ('DB_TYPE','mysqli');
define ('DB_HOST','localhost');
define ('SYS_VAR','<font color="#ff0000">Ver:</font>0.2 Bate <br>2017/03/08</p>');
define ('DB_NAME','hj');
define ('DB_DNS',DB_TYPE
				.'://'.DB_USER 
				.':'  .DB_PASS
				.'@'  .DB_HOST
				.'/'  .DB_NAME);	
//=======SYS===========================

define ('NOLOGIN',"尚未登入");
define ('SLD_IMG_PATH',"../uploads/SLD/");
define ('MENU_PATH',"../uploads/");
define ('EDISPLAY','<i class="fa fa-eye"></i>');
define ('NDISPLAY','<i class="fa fa-eye-slash" style="color:red"></i>');
define ('VIEWBTN','預覽(PC/Mobile)');
define ('OKBTN','確定');
define ('NGBTN','取消');
define ('DELBTN','刪除');
define ('ORDERMAX',300);//排序上限值	
	$link = mysql_connect(DB_HOST,DB_USER,DB_PASS) or die('Cannot connect to the DB');
	mysql_query("SET NAMES UTF8");
	mysql_select_db(DB_NAME,$link) or die('Cannot select the DB');
?>