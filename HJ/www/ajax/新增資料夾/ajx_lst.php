<?php
@session_start();
require_once ("../dist/js/xajax_core/xajax.inc.php");
$xajax = new xajax();
/*$xajax->registerFunction("GetItems");
$xajax->registerFunction("dacc");
$xajax->registerFunction("cacc");*/
$ajxobj=$xajax->registerFunction("GetItems");

//$ajxobj->useSingleQuote();
//$ajxobj->addParameter(XAJAX_INPUT_VALUE,"org");
$xajax->processRequest();

function GetItems($id){   
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);	
	//tsc_meet_items.state O,C 都要出現,因為要確認,故上次結案為C的,要改成S,就不會出現了
	//echo "user:".$_SESSION['USR']['UID']." p:".$_SESSION['USR']['POWER'];
	//$query="select tsc_meet_items.id ,tsc_meet_items.state ,issue_day ,issue ,action ,follow ,owner ,ok_day ,files_path from tsc_meet_items left join tsc_meet on tsc_meet_items.meet_id=tsc_meet.id where tsc_meet.state ='O' and tsc_meet_items.state in('O','C') and tsc_meet.id='$id' "; //
//	$query="select i.id,i.state ,issue_day ,issue ,r.action ,r.follow ,r.owner ,r.ok_day ,r.files_path ,r_id from tsc_meet_items as i left join tsc_meet as m on i.meet_id=m.id left join r_meet_items_acc as r on i.id=r.items_id where m.state ='O' and i.state in('O','D') and m.id='$id'";
$query="select i.id ,i.state ,issue_day ,issue ,r.action ,r.follow ,r.owner ,r.ok_day ,r.files_path from tsc_meet_items as i left join tsc_meet as m on i.meet_id=m.id right join r_meet_items_acc as r on i.id=r.items_id ".
	" left join sys_acc as a on r.owner=a.id where m.state ='O' and i.state in('O','D') and m.id='$id'";

	switch ($_SESSION['USR']['POWER']){
		default:
		case "1"://填報人只能看到自己的
		$query .=" and r.owner='".$_SESSION['USR']['UID']."'";
		break;
		case "2"://主管
		break;
		case "3": //主席
		
		break;
		case "4"://部門主管只能看到部門的
		$query .=" and a.ou_id='".$_SESSION['OUE']['OUID']."'";
		break;
		case "99"://無敵
		break;
	}
	//order
	 $query .= " order by issue_day asc, issue asc";
	
	$res=MDB2_query($mdb2 ,$query);
	$resule=$res->fetchAll();
	$httml="";
	foreach ( $resule as $i =>$rows){	
		if ($i % 2==0){
			$cl="even gradeC";
		}else{
			$cl="even gradeX";	
		}		
	$x=$i+1;//?
	$html .='<tr class="'.$cl.'" >';	
	
	foreach ($rows as $k => $val) {		
		switch ($k){
			case '0':
				$html .= "<td class=\"center\">". $x ."</td>";
			break;
			case '1':
				$tmpstr='<td><select name="state[]" disabled>
					<option value="O">Open</option>
					<option value="D">完成</option>
					</select></td>';
				$html .= str_replace('value="'.$val.'"','value="'.$val.'" selected',$tmpstr); //選取					
			break;	
			case '2':
				$html .="<td class='center'>$val</td>";
			break;
			case '6':
				$html .="<td class='center'>$val</td>";//<input type='hidden' name='owner[]' value='' />				
			break;
			case '7':
				$html .='<td class="center">'.$val.'</td>'; 
			break;
			case '8':				
				$html .='<td>';
				if (isset($val))
					$html .="<a href='$val'> <i class='fa fa-download fa-fw'> </i> 附件 </a>";				
				$html .='</td>';
			break;
			case "9":
				
			break;
			default:
				
				$html .="<td class=\"center\">$val</td>";
			break;
		}		
 	}
	$html .="</tr>";	
    // 產生html	
	}
	//=======
	$objResponse->assign("answer","innerHTML",$html);
	$objResponse->script('$(".datetype").datepicker({ dateFormat: "yy-mm-dd" });');//要重新定義一次日期元件的動作
	return $objResponse;	
}
/*
function dacc($id){  //刪帳號
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);	
	$query="select id from account where sno='$id'";
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();	
	$msg=$rows[0]."帳號已刪除";
	
	$query="delect from account where sno='$id'";
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();
	
	$objResponse->addAlert($msg);		
	return $objResponse;	
}
function cacc($id,$ouid,$spec){  //新帳號
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);	
	$ouid = GetOUID($ouid,$mdb2);
	$query="insert into account (id,ouid,spec) VALUES ( '$id','$ouid','$spec')";
	//$objResponse->addAlert($query);
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();
	$msg=$id."帳號已建立";
	$objResponse->addAlert($msg);		
	//$objResponse->assign("msg","innerHTML",$query);
	return $objResponse;	
}
function chgpage( $pagenumber ){
	$objResponse = new xajaxResponse();
	$pagenumber--;
	$mdb2 = MDB2_connect(DB_DNS);	
	$query="select sno,ouname ,spec, id, log from account,oulist where account.ouid=oulist.ouid and account.ouid in (select ouid from oulist where gid='$pagenumber')";

	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchAll();
	$htmlout='<table class="tablely" style="width: 690px;"><tr><th>機關單位名稱</th><th>承辦人(註解)</th><th>帳號</th><th >上次登入</th><th>功能</th></tr>';

	foreach ($rows as $values){
		$htmlout.='<tr>';
		foreach ($values as $key=>$value){			
			if ($key > 0){
			if ($value=="")
				$value="&nbsp;";
			$htmlout.='<td>'.$value.'</td>';
			}
		}
		$htmlout.='<td><a class="btn" onclick="javascript:xajax_repwd('.$values[0].')">[重設密碼]</a>|&nbsp;<a class="btn" onclick="javascript:xajax_dacc('.$values[0].')">[刪除]</a></td></tr>';
	}
	$htmlout.='</table>';
	$objResponse->assign("answer","innerHTML",$htmlout);
	return $objResponse;
}
*/
?>