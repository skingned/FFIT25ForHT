<?php
@session_start();	
// check if fields passed are empty
if(empty($_POST['name'])  		||
   empty($_POST['email']) 		||
   empty($_POST['message'])	||
   empty($_POST['type'])	||
   empty($_POST['title'])	||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	echo "没有提供参數!";
	return false;
   }

$name = $_POST['name'];
$email_address = $_POST['email'];
$message = $_POST['message'];
$type = $_POST['type'];
$title=$_POST['title'];
//寫入db
include_once ("../include.php");
$mdb2 = MDB2_connect(DB_DNS);//資料庫連線
$query ="insert into sys_quest (name,typex,email,title,content) values ('$name','$type','$email_address','$title','$message')";
//echo $query;
$res=MDB2_query($mdb2 ,$query);
	//	$rows=$res->fetchAll();	

//phpmailer send mail
include_once("../class/PHPMailer/PHPMailerAutoload.php");
	$mail= new PHPMailer(); //建立新物件    
	$mail->SMTPDebug = 2;    
    $mail->Mailer = 'smtp';
	$mail->IsSMTP(); //設定使用SMTP方式寄信  
	$mail->SMTPAuth = true; //設定SMTP需要驗證        
	$mail->Username = "skingned6665@gmail.com"; //設定驗證帳號      <==設定部分請教  
	$mail->Password = "Ned@sking"; //設定驗證密碼      
	$mail->SMTPSecure = "ssl"; // Gmail的SMTP主機需要使用SSL連線   
	$mail->Host = "smtp.gmail.com"; //Gamil的SMTP主機        
	$mail->Port = 465;  //Gamil的SMTP主機的SMTP埠位為465埠。        
	$mail->CharSet = "utf8"; //設定郵件編碼        
//$mail->WordWrap = 50;	//每50行斷一次行
/*	if (trim($ATTC)!=""){
		$mail->AddAttachment($ATTC);// 附加檔案
	}*/	
	$mail->From = 'ffit_sking@gmail.com'; //設定寄件者信箱        
	$mail->FromName = '豐富科技網站'; //設定寄件者姓名 
	//設定郵件內容 
$email_subject = "您有一封來自豐富科技( $name )的意見反應:\r\n";
$email_body ="$name\r\n於".date('Y-m-d h:i:s')." 反應意見如下:\r\n$type  類\r\n\r\n$message\r\n".
			 "<hr>回覆資訊如下:\r\n"
			 ."Email: $email_address\r\n";
	$mail->Subject = trim($email_subject); //設定郵件標題        
	$mail->Body = $email_body;
	 	
	$mail->IsHTML(true); //設定郵件內容為HTML 
		
	$mail->AddAddress("skingned6665@gmail.com","sking"); //設定收件者郵件及名稱        
	$mail->AddCC($email_address,$name); //副本//設定收件者郵件及名稱 
	if(!$mail->Send()) {        
 		$msg="發送異常!! Mailer Error: " . $mail->ErrorInfo."  ".$email_address;  
	} else { 
		$msg="已發送給".$name."!!(mail to :".$email_address.")";     	   
	} 
	//echo '<Script>alert('.$msg.');</script>';	
//	return $msg;
/*

			
// create email body and send it	
$to = 'skingned6665@gmail.com'; // ----->>> put your email to receive mails
$email_subject = "您有一封來自$name的 $type 意見反應:\r\n";
$email_body ="$name\r\n於".date()."時的反應意見如下:\r\n$type\r\n\r\n$message\r\n".
			 "<hr>回覆資訊如下:\r\n"
			 ."Email: $email_address\r\n";

$headers = "From: FFIT@GMAIL.COM\n";
$headers .= "Reply-To: $email_address";	//副本


mail($to,$email_subject,$email_body,$headers);
return true;*/			
?>