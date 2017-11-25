<?php
@session_start();
/*query meet name & response json format*/
include_once ("../../include.php");
//==sql injection=====
$_POST=quotes($_POST);
$_GET=quotes($_GET);
$meet_type=$_GET['MT'];
	$mdb2 = MDB2_connect(DB_DNS);//資料庫連線

	$query="select DISTINCT i.id,state ,DATE_FORMAT(issue_day,GET_FORMAT(DATE,'JIS')),issue,action,i.files_path,GROUP_CONCAT(DISTINCT p.owner),
						if (
				r.files_path <>'',
				GROUP_CONCAT(
				CONCAT('<a class=flw_s>',DATE_FORMAT(r.md_day,GET_FORMAT(DATE,'JIS')),' (',r.owner,')</a><a> 預計完成:',DATE_FORMAT(ok_day,GET_FORMAT(DATE,'JIS')),'</a> <a href=''',r.files_path,''' target=''_blank'' style=''color:green''> <i class=''fa fa-file-o''></i> 附件</a>  <Br>',r.follow) 
				order by i.id asc ,r.md_day asc SEPARATOR '<hr>')
				,
				GROUP_CONCAT(
				CONCAT('<a class=flw_s>',DATE_FORMAT(r.md_day,GET_FORMAT(DATE,'JIS')),' (',r.owner,')</a><a> 預計完成:',DATE_FORMAT(ok_day,GET_FORMAT(DATE,'JIS')),'</a> <Br>',r.follow) 
				order by i.id asc ,r.md_day asc SEPARATOR '<hr>')
				) as follow
			from tsc_meet_items as i
			left join r_meet_items_acc_permissions as p on i.id=p.items_id
			left join r_meet_items_acc as r on i.id=r.items_id	
			where i.id='".$_GET[MT] ."'
			group by i.id";	
			// echo $query;	
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();	
	echo  json_encode($rows);	
?>