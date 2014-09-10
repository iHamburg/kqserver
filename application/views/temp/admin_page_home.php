

<h1><?php echo $title;?></h1>
<p><?php echo anchor('admin/pages/create','Create new page');?></p>
<?php 

if($this->session->flashdata('msg')){
	echo "<div class='message'>".$this->session->flashdata('msg')."</div>";
}

if(!empty($pages)){
//	echo $this->table->generate($categories);

	echo "<table border='1' width='400'>";
	foreach ($pages as $key => $list) {
		echo "<tr>";
		echo "<td>".$list['id']."</td>";
		echo "<td>".$list['name']."</td>";
		echo "<td>".$list['status']."</td>";
		echo "<td align='center'>".anchor('admin/pages/edit/'.$list['id'],'edit')." | ".anchor('admin/pages/delete/'.$list['id'],'delete')."</td>";
		echo "</tr>";
		
	}
	echo "</table>";
}
?>

