<?php 
require_once ("../dist/js/xajax_core/xajax.inc.php");
$xajax = new xajax();
$ajxobj=$xajax->registerFunction("chgpage");
//$ajxobj->useSingleQuote();
//$ajxobj->addParameter(XAJAX_INPUT_VALUE,"org");
$xajax->processRequest();

function chgpage( $pagenumber ){
	$objResponse = new xajaxResponse();
	//$htmlout ='<table class="tablely">';
	//$htmlout .='<tr><th>機關單位名稱</th><th>帳號</th><th>上次登入</th><th>功能</th></tr>';
	//var_dump($pagenumber);

	/*switch ($pagenumber){
		default:
		
		case "":		
			$htmlout .='<tr><td>統計處</td><td>sec0001</td><td>2011/08/24 14:22:30</td><td><a href="?mode=eaccount&uid=sec0001&fun=r">[重設密碼]</a>&nbsp;|&nbsp;<a href="?mode=eaccount&uid=sec0001&fun=e">[修改]</a>&nbsp;|&nbsp;<a href="?mode=eaccount&uid=sec0001&fun=d">[刪除]</a></td></tr>';
		break;
		case "1":
		
		break;
		case "2":
		
		break;
	}*/
	//$htmlout .='</table>';
	$objResponse->assign("answer","innerHTML",$pagenumber);
	return $objResponse;
}


?>