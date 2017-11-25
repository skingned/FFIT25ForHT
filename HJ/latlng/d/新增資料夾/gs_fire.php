<?php
/* require the store_id as the parameter */
/*check ip*/
$tablename="od_firebbigade";
if(isset($_GET['idx']) && isset($_GET['lat']) && isset($_GET['lng'])) {
	/* soak in the passed variable or set our own */
	/*$number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
	$format = strtolower($_GET['format']) == 'xml' ? 'xml' : 'json'; //json is the default
	$user_id = intval($_GET['store_id']); //no default
*/
/* connect to the db */	
	include_once "config/config.php";
	/* grab the posts from the db */
	//$query = "SELECT id,BAN_NO,CMPY_NAME,RESP_NAME,CMPY_ADD FROM c1 WHERE 1=1  ORDER BY ID DESC LIMIT $number_of_posts";
	$query = "update $tablename set lat='".$_GET['lat']."',lng='".$_GET['lng']."' WHERE id='".$_GET['idx']."'";
	$result = mysql_query($query,$link) or die('Errant query:  '.$query);

	echo "[stats:ok]";
	/* disconnect from the db */
	@mysql_close($link);
}
?>