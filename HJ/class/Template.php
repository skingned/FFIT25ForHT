<?php

//echo $include_path;
require_once ('Smarty/Smarty.class.php');

class Template extends Smarty{
	 function Template()	 {
		//work path default
		$this->template_dir = APP_REAL_PATH ."/tpl/";  //�˪����|
		$this->compile_dir = APP_REAL_PATH ."/templates_c/";   //�sĶ�n���s���}
		$this->plugins_dir[] = APP_REAL_PATH . "/plugins/";
        $this->cache_dir = APP_REAL_PATH . "/cache/";
	}
}
?>