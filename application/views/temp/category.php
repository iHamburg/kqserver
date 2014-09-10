

<div id="pleft">
	<h2><?php echo $category['name'];?></h2>
	<p><?php echo $category['shortdesc'];?></p>
	<?php 
		
		foreach ($listing as $key=>$list){
//			echo "<img src='".$list['thumbnail']." border = '0' align='left'/>/n";
		
			switch($level){
				case '1': // sub category
					echo anchor('welcome/cat/'.$list['id'],$list['name']);
					echo "<p>".$list['shortdesc']."</p>";
					echo '<br/>';
					break;
				case '2':  // products
//					echo 'level 2';
					echo "<img src='".imgUrlOfThumb($list['thumbnail'])."' border = '0' align='left'/>";
//					echo "<p>".$list['name']."</p>";
					echo anchor('welcome/product/'.$list['id'],$list['name']);
					echo "<p>".$list['shortdesc']."</p>";
					echo "<br style='clear:both'/>";
					echo "<br style='clear:both'/>";
					break;
			}
		}
	
	?>
</div>