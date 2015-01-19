<?php
class Tload
{
//
//echo 'ddd';
	static function loadClass($class_name)
	{
//		echo 'eee';
//		$filename = $class_name.".class.php";
 		$filename = dirname(__FILE__).DIRECTORY_SEPARATOR.strtolower($class_name).'.class.php';
 		
// 		echo $class_name;
		if (is_file($filename)) 
			return include_once $filename;
	
	}
//	spl_autoload_register('loadClass',true,true);
	
//	$a = new Blada();
//	$a->aa();
//	echo 'after load';

}
//$a = new Test();//实现自动加载，很多框架就用这种方法自动加载类 

spl_autoload_register(array('Tload','loadClass'));