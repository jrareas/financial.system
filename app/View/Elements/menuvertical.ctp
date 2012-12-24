<?php
	//print_r($menus);
?>


<?php


$arrayMenu = array();

foreach ($menus as $menu){
	$arrayMenu[$menu['Menu']['id']] = array("pid" => $menu['Menu']['parent_menu'], "name" => $menu['Menu']['menu_display'], "url" => $menu['Menu']['menu_link']);
}


//createTree($arrayCategories, 0);

function createTree($array, $curParent, $currLevel = 0, $prevLevel = -1) {

	foreach ($array as $categoryId => $category) {
	
		if ($curParent == $category['pid']) {
		
			if($category['pid']==0) $class="id=navmenu"; else $class="";
			if ($currLevel > $prevLevel) echo " <ul $class> ";
			//if ($currLevel > $prevLevel) echo " <ul> ";
			
			if ($currLevel == $prevLevel) echo " </li> ";
			
			//echo '<li id="'.$categoryId.'" ><a href="'.$category['url'].'">'.$category['name'].'</a>';
			echo '<li><a href="'.$category['url'].'">'.$category['name'].'</a>';
			
			if ($currLevel > $prevLevel) { $prevLevel = $currLevel; }
			
			$currLevel++;
			
			createTree ($array, $categoryId, $currLevel, $prevLevel);
			
			$currLevel--;
		}
		
	}
	
	if ($currLevel == $prevLevel) echo " </li> </ul> ";

}
?>



<?php
  createTree($arrayMenu, 0);
?>