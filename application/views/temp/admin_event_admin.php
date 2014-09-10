<div class="container">
<h1><?php echo $title;?></h1>
<div class="row">
	<div class="col-md-2">
		<ul class="nav nav-pills nav-stacked">
		  <li class="active"><a href='#'>报名会员</a></li>
<!--		   <li class="active"><?php echo '报名会员';?></li>-->
		  <!--
		  <li><?php echo anchor('admin/events/create','新建活动');?></li>
		--></ul>
	</div>
	<div class="col-md-10">
	<p>总共报名人数: <?php echo count($participation)?></p>
<?php 

if($this->session->flashdata('msg')){
	echo "<div class='message'>".$this->session->flashdata('msg')."</div>";
}

	
if(!empty($participation)){


	echo "<table class='table table-striped table-bordered table-hover table-responsive'>";
	
	$headers = array('会员编号','会员姓名','用户名','报名时间','会员管理');
	echo "<tr>";
	foreach ($headers as $header) {
		
		echo "<th>".$header."</th>";
		
	}
	echo "</tr>";
	foreach ($participation as $key => $list) {
		echo "<tr>";
		echo "<td >".$list['id']."</td>";
		echo "<td>".$list['realname']."</td>";
		echo "<td>".$list['username']."</td>";
		echo "<td>".transTime($list['enroll_time'])."</td>";
		
		echo "<td align='center'>".anchor('admin/users/edit/'.$list['id'],'查看')."</td>";
		echo "</tr>";
		
	}
	echo "</table>";
	
		
}
?>
	</div>
</div>

</div>