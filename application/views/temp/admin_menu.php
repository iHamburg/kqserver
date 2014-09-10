<div class="container">
<h1><?php echo $title;?></h1>
	
	<div class="col-md-10">
		
	<?php 	
		if($this->session->flashdata('msg')){
			echo "<div class='msg'>".$this->session->flashdata('msg')."</div><br/>";
		}
		
		print_r($menu);
	?>
	
	
		
	</div>
</div>

