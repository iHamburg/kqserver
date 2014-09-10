<div class="container">
<h1><?php echo $title;?></h1>
	<div class="row">
		<div class="col-md-2">
			<ul class="nav nav-pills nav-stacked">
			  <li class="active"><?php echo anchor('admin/events','所有活动');?></li>
			  <li><?php echo anchor('admin/events/create','新建活动');?></li>
			</ul>
		</div>
		<div class="col-md-10">
		<?php 
		
		if($this->session->flashdata('msg')){
			echo "<div class='msg'>".$this->session->flashdata('msg')."</div><br/>";
		}
		
		if(!empty($events)){
		
			echo "<table class='table table-striped table-bordered table-hover table-responsive'>";
			
			$headers = array('活动标号','活动名称','活动日期','活动类型','报名人数','活动管理');
			echo "<tr>";
			foreach ($headers as $header) {
				
				echo "<th>".$header."</th>";
				
			}
			echo "</tr>";
			foreach ($events as $key => $list) {
				echo "<tr>";
				echo "<td>".$list['id']."</td>";
				echo "<td>".$list['name']."</td>";
				echo "<td>".$list['datetime']."</td>";
				echo "<td>".$list['tag']."</td>";
				echo "<td>".$applicantsnumbers[$key]."</td>";
				$attributs = array('class'=>'close');
				echo "<td align='center'>".anchor('admin/events/edit/'.$list['id'],'编辑')." | ".
					anchor('events/enrollajaxapi/'.$list['id'],'预览',array('target'=>'_blank'))." | ".
					anchor('admin/events/admin/'.$list['id'],'管理')." | ".
					anchor('admin/events/delete/'.$list['id'],'删除')."</td>";
				echo "</tr>";
				
			}
			echo "</table>";
			
				
		}
		?>
		
		<div class="pagination"><?php echo $this->pagination->create_links()?></div>
	</div>
</div>

</div>