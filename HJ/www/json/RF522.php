<?php
/*
function :
	get RF522=>Wemos(esp8266)=>Web Server=> android
		LED	 <=	   msg		 <=	
input: 
		URL /RF522.PHP?sno=&cn=
output:
		msg

*/
@session_start();
/*query meet name & response json format */
include_once ("../../include.php");
//==sql injection=====
$mdb2 = MDB2_connect(DB_DNS);//資料庫連線
//$_GET=quotes($_GET);
$IP=$_SERVER['REMOTE_ADDR'];
//只能用POST
	$query = "INSERT INTO sys_log ( ip, tmpdata) VALUES (".$IP.",".json_encode($_GET).")";
	$res=MDB2_query($mdb2 ,$query);
	
if ($_SERVER['REQUEST_METHOD'] == "GET") {	
	$_GET=quotes($_GET);
	//驗證格式
	//var_dump($_GET);
	if (!empty($IP) && !empty($_GET['sno']) && !empty($_GET['cn'])){		
		//寫入記錄
		$query = "INSERT INTO door (ip,sno, card_number) VALUES ('$IP','".$_GET['sno']."','".$_GET['cn']."')";
		$res=MDB2_query($mdb2 ,$query);
		$sendtime=date("Y-m-d H:i:s");
		//查看有無要通知的事
		$query = "select id,card_number,msg from RF_MSG where card_number='".$_GET['cn']."'";
		$res=MDB2_query($mdb2 ,$query);
		$rows=$res->fetchAll(MDB2_FETCHMODE_ASSOC);	
		if (!empty($rows)){
		$ID=implode("','",$rows[0]);		
		$query = "UPDATE RF_MSG set sendtime='$sendtime' where id in ('$ID')";
		$res=MDB2_query($mdb2 ,$query);
		///=$rows;
		//$rows=array("res"=>$rows);
		//$rows=$rows[0];
		$msg=json_encode(array('res'=>$rows));//通知到機器
		echo $msg;//<==送回主機
		/*
		//===========通知到手機============
		$APPmsg = array
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
		//push_to_android($APPmsg);
		//===============================
		//==========send email===============
		$subject="wemos (Adruino) + RF522 ";
		$mail=array('skingned6665@gmail.com','Sking');
		$RT=SendMailToG($mail,$subject,$msg);
		*/
		
		}else{
			echo json_encode(array('state'=>'GET'));
		}
	}else{
		echo json_encode(array('state'=>'PNG'));//參數錯誤
	}
}else{
	echo json_encode(array('state'=>'MNG'));//存取方式錯誤
}

	
?>