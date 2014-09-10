<div class="container">
<h1><?php echo $title;?></h1>
<p><?php echo anchor('admin/products/create','Create new product');?></p>

<div class="row">
	<div class="col-md-3">
		<ul class="nav nav-pills nav-stacked">
	  <li class="active"><a href="#">Home</a></li>
	  <li><a href="#">Profile</a></li>
	  <li><a href="#">Messages</a></li>
	</ul>
	</div>
	<div class="col-md-8">
	
<?php 

if($this->session->flashdata('msg')){
	echo "<div class='message'>".$this->session->flashdata('msg')."</div>";
}

if(!empty($products)){
//	echo $this->table->generate($categories);

	echo "<table class='table table-striped table-bordered table-hover table-condensed table-responsive'>";
	foreach ($products as $key => $list) {
		echo "<tr>";
		echo "<td class='success'>".$list['id']."</td>";
		echo "<td>".$list['name']."</td>";
		echo "<td>".$list['status']."</td>";
		echo "<td align='center'>".anchor('admin/products/edit/'.$list['id'],'edit')." | ".anchor('admin/products/delete/'.$list['id'],'delete')."</td>";
		echo "</tr>";
		
	}
	echo "</table>";
	
		
}
?>
	</div>
</div>

</div>