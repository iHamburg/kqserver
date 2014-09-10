

<h1><?php echo $title;?></h1>
<p><?php echo anchor('admin/categories/create','Create new category');?></p>
<?php 

if($this->session->flashdata('msg')){
	echo "<div class='message'>".$this->session->flashdata('msg')."</div>";
}

if(!empty($categories)){
//	echo $this->table->generate($categories);

	echo "<table border='1' width='400'>";
	foreach ($categories as $key => $list) {
		echo "<tr>";
		echo "<td>".$list['id']."</td>";
		echo "<td>".$list['name']."</td>";
		echo "<td>".$list['status']."</td>";
		echo "<td align='center'>".anchor('admin/categories/edit/'.$list['id'],'edit')." | ".anchor('admin/categories/delete/'.$list['id'],'delete')."</td>";
		echo "</tr>";
		
	}
	echo "</table>";
}
?>

