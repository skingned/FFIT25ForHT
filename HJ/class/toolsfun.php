<?php
header("Content-Type:text/html; charset=utf-8");
//===mdb2 function ======

/***************************
function for Dev 
***************************/
/* 列出 function */
function ListFunction($file="function.php",$fstring="/functon /"){
	$handle = fopen(file, "r");
	if ($handle) {
		while (($buffer = trim(fgets($handle, 4096))) !== false) {
			if (preg_match($fstring, $buffer, $matches))
				echo $matches."<BR>";
						
		}
		if (!feof($handle)) {
			echo "Error: unexpected fgets() fail\n";
		}
		fclose($handle);
	}
}
/* */

?>