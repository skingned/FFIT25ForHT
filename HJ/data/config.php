<?php
//mysql
/*define ('DB_HOST','mysql9.000webhost.com');
define ('DB_USER','a7362782_m2016');
define ('DB_PASS','!QAZ1qaz');
define ('DB_NAME','a7362782_m2016');*/


define ('DB_HOST','localhost');
define ('DB_USER','root');
//define ('DB_PASS','!QAZ1qaz');
//define ('DB_PASS','Vac@lulala');
define ('DB_NAME','HJ');
switch (gethostname()){
	case "Sking":
		//define ('DB_USER','root');
		define ('DB_PASS','!QAZ1qaz');		
		define ('MAPKEY' ,"AIzaSyBBXHUUOD1cSwsHzXcCxNLwkLLVX0PHB8I");
	break;
	case "FFIT":
		//define ('DB_USER','root');
		define ('DB_PASS','Vac@lulala');		
		define ('MAPKEY' ,"AIzaSyAAsffnUQ3lD6JHzKSy_Rq_qGp-BYa1qnM");
	break;
	default:
		//define ('DB_USER','root');
		define ('DB_PASS','Vac@lulala');		
		define ('MAPKEY' ,"AIzaSyAAsffnUQ3lD6JHzKSy_Rq_qGp-BYa1qnM");
	break;
}







//write to db
//define ('TODB',false);
define ('TODB',true);//將別人查的經濟部資料,存到我的db
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


?>