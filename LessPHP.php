<?php
/*
Author : Nicolas Badey
*/

class LessPHP extends lessc {

protected $lessOutput='';
protected $cssCache='';

	function createVar($var) {
		foreach($var as $key => $value){
			$this->cssCache.= '@'.$key.'='. strip_tags(urldecode($value)) . ';'."\n";
		}
	}
	function loadFiles($files) {
		foreach ($files as $path){
			$path=__DIR__.'/../'.$path;
			if (file_exists($path))
				$this->cssCache.=file_get_contents($path);
		}
	}
	function writeFile($name,$min=true){
		file_put_contents($name,($min==true)?$this->minifie():$this->lessOutput);
	}
	function minifie(){
		return preg_replace("/(\r\n|\n|\r)/", '',$this->lessOutput );
	}
	function output($min=false){
		ob_start('ob_gzhandler'); 
		header('Content-type: text/css');
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		if ($min)
			echo $this->minifie();
		else
			echo $this->lessOutput;
	}
	
	function parse($str=null){
		$this->lessOutput= parent::parse($this->cssCache);
	}
}
?>