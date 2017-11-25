<?
/* require the store_id as the parameter */
/*check ip*/
//if(isset($_GET['store_id']) && intval($_GET['store_id'])) {
	/* soak in the passed variable or set our own */
	$number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
	$format = strtolower($_GET['format']) == 'xml' ? 'xml' : 'json'; //json is the default
	$user_id = intval($_GET['store_id']); //no default
	/* connect to the db */	
	include_once "xmysql.php";
	//$query = "SELECT id,BAN_NO,CMPY_NAME,RESP_NAME,CMPY_ADD FROM c1 WHERE lng='' and lat='' and cmpy_add <>'' ORDER BY ID desc LIMIT $number_of_posts";
	$query = "SELECT id ,addr FROM fire WHERE lng='' and lat='' and addr <>'' ORDER BY id desc LIMIT $number_of_posts";
	
	$result = mysql_query($query,$link) or die('Errant query:  '.$query);

	/* create one master array of the records */
	$posts = array();
	if(mysql_num_rows($result)) {
		while($post =mysql_fetch_assoc($result)) {
			$posts[] = array('post'=> $post);
		}
	}

	/* output in necessary format */
	if($format == 'json') {
		header('Content-type: application/json');
		//print_r($posts);
		echo json_encode(array('posts'=>$posts));
	}
	else {
		header('Content-type: text/xml');
		echo '<posts>';
		foreach($posts as $index => $post) {
			if(is_array($post)) {
				foreach($post as $key => $value) {
					echo '<',$key,'>';
					if(is_array($value)) {
						foreach($value as $tag => $val) {
							echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
						}
					}
					echo '</',$key,'>';
				}
			}
		}
		echo '</posts>';
	}

	/* disconnect from the db */
	@mysql_close($link);
//}
?>