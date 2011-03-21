<?php

/*
It's a basic example

For generate css file from multiple LESS files
EXAMPLE.php?paths=css/c.css;css/red.css&color=%23A60B29&name=red

Direct Gzip output :
EXAMPLE.php?paths=css/c.css;css/red.css&color=%23A60B29

not forget to add CSS files for the example

*/


require 'lessc.inc.php';
require 'LessPHP.php';




$paths=explode(';',$_GET['paths']);
unset($_GET['paths']);

if (isset ($_GET['name'])){
	$name=$_GET['name'];
	unset($_GET['name']);
}





$less=new LessPHP();

/*
* Create LESS var From PHP's table key=>value
*/
$less->createVar($_GET);


/*
* Loads multiples files from table
*/
$less->loadFiles($paths);


/*
* Parse the buffer
*/
$less->parse();

if(!isset($name)){ //dev

	/*
	* Direct output set (true) for minify
	*/
	$less->output();
	// $less->writeFile(__DIR__.'/cache/styles.css');
}
else { // prod

	/*
	* write single file, set ($name,true) for minify
	*/
	$less->writeFile($name);
	
	
}
?>