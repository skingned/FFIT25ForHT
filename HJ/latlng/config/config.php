<?php
	/* connect to the db */
	//$link = mysql_connect('localhost','root','sking@168') or die('Cannot connect to the DB');
	define ('DB_HOST','localhost');
	define ('DB_USER','root');
	define ('DB_PASS','!QAZ1qaz');
	define ('DB_NAME','hj');

	$link = mysql_connect(DB_HOST,DB_USER,DB_PASS) or die('Cannot connect to the DB');
	mysql_query("SET NAMES UTF8");
	mysql_select_db(DB_NAME,$link) or die('Cannot select the DB');
?>