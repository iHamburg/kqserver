<?php
if (count($navlist)){
  echo "<ul>";
  foreach ($navlist as $id => $name){
  
    	echo "<li class='cat'>";
    	echo anchor("welcome/cat/$id",$name);
    	echo "</li>\n";
 
	
  }
  echo "</ul>\n";
}
?>