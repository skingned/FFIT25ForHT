<?php 
require_once ("../dist/js/xajax_core/xajax.inc.php");
$xajax = new xajax();
//$xajax->debugOn();
$ajxobj=$xajax->registerFunction("GetItems");

//$ajxobj->useSingleQuote();
//$ajxobj->addParameter(XAJAX_INPUT_VALUE,"org");
$xajax->processRequest();
function GetItems($tid,$mid){   //改密碼
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);	
	//帶出尚未結案的會議資料
	//$query="select i.id,i.state ,issue_day ,issue ,r.action ,r.follow ,r.owner ,r.ok_day ,r.files_path ,r_id from tsc_meet_items as i left join tsc_meet as m on i.meet_id=m.id left join r_meet_items_acc as r on i.id=r.items_id where m.state ='O' and i.state in('O','D') and r.MASK='N' and m.type_id='$tid' and m.id <>'$mid'";
	$query="select i.id,i.state ,issue_day ,issue ,r.action ,r.follow ,r.owner ,r.ok_day ,r.files_path ,r_id from tsc_meet_items as i left join tsc_meet as m on i.meet_id=m.id left join r_meet_items_acc as r on i.id=r.items_id where m.state ='O' and i.state in('O','D') and r.MASK='N' and m.type_id='$tid' and m.id <>'$mid'";
	$query .= " order by issue_day asc, issue asc";
	//$objResponse->alert($query);
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
	$html .='<tr class="'.$cl.'" ><td><input type="checkbox" class="ck" name="ck[]"> </td>';	
	
	foreach ($rows as $k => $val) {		
		switch ($k){
			case '0':
				$html .= "<td class=\"center\">". $x ."<input type='hidden' name='id[]' value='$val'/><input type='hidden' name='rid[]' value='".$rows[9]."'/></td>";
			break;
			case '1':
				$tmpstr='<td><select name="state[]">
					<option value="O">Open</option>
					<option value="D">完成</option>
					<option value="C">Close</option>
					</select></td>';
				$html .= str_replace('value="'.$val.'"','value="'.$val.'" selected',$tmpstr); //選取					
			break;	
			case '2':
				$html .="<td class='center'>$val<input type='hidden' name=cday[] /></td>";
			break;
			case '6'://owner
				$html .="<td class='center'>$val";
				switch ($_SESSION['USR']['POWER']){
					default:
					case '1':
					break;
					//以下身分可增加別的owner
					case '2':					
					case '99':
					//$html .='<br><button type="button" class="a_owner btn btn-danger" text="add owner" value="'.$rows[0].'">+</button><ul></ul>';//拿到的是meet items id
					break;
				}				
				$html .="</td>";				
			break;
			case '7':
			//	$html .='<td class="center">'.$val.'<br><input name="okday[]" class="form-control datetype" ></td>'; 
			break;
			case '8':				
			/*	$html .='<td><input class="upfile" name="ufile[]" type="file">';
				if (isset($val))
					$html .="<a href='$val'> <i class='fa fa-download fa-fw'> </i> 附件 </a>";				
				$html .='</td>';*/
			break;
			case "9":
				
			break;
			default:
				switch($k){		
					case '3':
						$v='name="Issue[]" style="display:none;" ';
					break;
					case "4":
						$v='name="Action[]"';
					break;
					case "5":
						$v='name="fl[]"';
					break;
				}
				$html .="<td class=\"center\">$val<br><textarea $v ></textarea></td>";
			break;
		}		
 	}
	$html .="</tr>";	
    // 產生html	
	}
	//=======
	$objResponse->assign("answer","innerHTML",$html);
	$objResponse->script('$(".datetype").datepicker({ dateFormat: "yy-mm-dd" });');//要重新定義一次日期元件的動作
			//增加owner =>另開選取視窗
	return $objResponse;	
}
?>