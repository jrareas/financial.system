<?php
	function GetClass($className)
	{
		static $classes;
		if(!isset($classes[$className])) {
			$classes[$className] = new $className;
		}
		$class = &$classes[$className];
		return $class;
	}
	function GetConfig($config){
		if(array_key_exists($config, $GLOBALS)){
			return $GLOBALS[$config];
		}
	}
?>