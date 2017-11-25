<?php

@session_start();
require_once ("../dist/js/xajax_core/xajax.inc.php");
$xajax = new xajax();
$ajxobj=$xajax->registerFunction("del");
$ajxobj=$xajax->registerFunction("left");
$ajxobj=$xajax->registerFunction("order");
$ajxobj=$xajax->registerFunction("Scategory");

//$ajxobj->useSingleQuote();
//$ajxobj->addParameter(XAJAX_INPUT_VALUE,"org");
$xajax->processRequest();

function Scategory($formData,$type){//$type分類名   
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);
	//$formData['title']=
	$objResponse->assign("msg","innerHTML",nl2br(print_r($formData, true)));//查看
	//取值如何(無則同名稱)
	//值如何給?update 又如何區分
	if (!empty($formData['title'])){
		$val=empty($formData['val'])?$formData['title']:$formData['val'];
		$en=$formData["cstate"]==0?'':'Y'; //<==Hidden就改不了啦?所以列表那一頁要列出所有的,並加狀態
		$query="insert into sys_category (form_type,title,val,sno,enable,img_path) values('$type','".$formData['title']."','$val','1','$en','".$formData['picfile']."')";		
		$res=MDB2_query($mdb2 ,$query);	
		
		$objResponse->addAlert($type."類別已新增");
		$objResponse->append("msg","innerHTML",$query);
	}else{
		$objResponse->alert("資料錯誤");
	}

	
	//$objResponse->assign("msg","innerHTML",$query);
	//重新出現選項在下拉選項中
	$objResponse->append("CATEGORY","innerHTML",'<option value="$val" selected>'.$formData['title'].'</option>');	
	
	return $objResponse;	
}

//刪除
function del($id){   
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);
	$query="DELETE FROM sys_category WHERE id='$id'"; //刪了自己這一筆
	$res=MDB2_query($mdb2 ,$query);
	//$objResponse->addAlert($id." 已刪除");
	$_SESSION['ajaxreload']="y";
	$objResponse->script('location.reload(true);');
	return $objResponse;	
}

//排序
function order($id,$type){   
	$objResponse = new xajaxResponse();
	$mdb2 = MDB2_connect(DB_DNS);
	
	//find sno
	$query="select sno from sys_category where id ='$id'";
	$res=MDB2_query($mdb2 ,$query);
	$rows=$res->fetchRow();
	
	//~UP/DOWN
	switch(strtoupper($type)){
		case "UP":
			if ($rows[0] > 0){
				$val=$rows[0]-1;
				$query="update sys_category set sno='$val' where id='".$id."'";
				$res=MDB2_query($mdb2 ,$query);			
				$msg=$id."排序已向前";
			}else{
				$msg=$id."已到最前";
			}			
		break;
		case "DOWN":			
			if ($rows[0] < ORDERMAX){//限制排序最大值
				$val=$rows[0]+1;
				$query="update sys_category set sno='$val' where id='".$id."'";
				$res=MDB2_query($mdb2 ,$query);			
				$msg=$id."排序已向後";
			}else{
				$msg=$id."已到最後(".ORDERMAX.")";
			}			
		break;
	}
	//如何顯示結果,重整
	//1.變更dataTables-example-2的內容
	//2.reload lightbox_me
	
	//$objResponse->assign("msg","innerHTML",$query);
	$_SESSION['ajaxreload']="y";
	//try to reload
	$objResponse->script('location.reload(true);');//run 就掛 <==不run 如何更新資料
	//$objResponse->script('$("#addx").trigger( "click" );');
	//設定datatable reload
	//table
	//$objResponse->script('$("#append").trigger( "click" );');
	/*$objResponse->script("table.on( 'xhr', function () {
						var json = table.ajax.json();
						alert( json.data.length +' row(s) were loaded' );
					} );");*/
	/*$objResponse->script('
	
				var ele= $("#maintain").lightbox_me({
				centered: true, 
				onLoad: function() { 			
				$("#BTNM_OK").click(function(){				
					xajax_Scategory(xajax.getFormValues("form_c"),"PDM");
					ele.trigger("close");
				 });
				
				$("#BTNM_NG").click(function(){
					ele.trigger("close");
				 });
					}					
				});');*/
	$objResponse->addAlert($msg);
	//$objResponse->script('location.reload();');
	return $objResponse;	
}


?>