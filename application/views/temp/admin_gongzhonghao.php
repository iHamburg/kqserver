<div class="container">
<h1><?php echo $weixin->name.$title;?></h1>
	
	<div class="col-md-10">
		

<?php 	
		if($this->session->flashdata('msg')){
			echo "<div class='msg'>".$this->session->flashdata('msg')."</div><br/>";
		}
	?>
	
	<p>开发模式接口地址: <?php echo site_url($weixin->url)?></p>		
	<p>token: <?php echo $weixin->token?></p>
		
	</div>
</div>

