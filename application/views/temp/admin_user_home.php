
<h1><?php echo $title;?></h1>
<div class="row">
		<div class="col-md-2">
			<ul class="nav nav-pills nav-stacked">
			  <li class="active"><?php echo anchor('admin/users','所有会员');?></li>
			  <li><?php echo anchor('admin/users/create','新建会员');?></li>
			</ul>
		</div>
		<div class="col-md-10">
<?php 	
		if($this->session->flashdata('msg')){
			echo "<div class='message'>".$this->session->flashdata('msg')."</div>";
		}
		
		if(!empty($users)){
		
		
			echo "<table class='table table-striped table-bordered table-hover table-responsive'>";
			
			$headers = array('会员编号','会员姓名','用户名','注册时间','会员管理');
			echo "<tr>";
			foreach ($headers as $header) {
				echo "<th>".$header."</th>";
			}
			echo "</tr>";
			foreach ($users as $key => $list) {
				echo "<tr>";
				echo "<td>".$list['id']."</td>";
				echo "<td>".$list['realname']."</td>";
				echo "<td>".$list['username']."</td>";
				echo "<td>".$list['reg_time']."</td>";
				echo "<td align='center'>".anchor('admin/users/edit/'.$list['id'],'编辑')." | ".anchor('admin/users/delete/'.$list['id'],'删除')."</td>";
				echo "</tr>";
				
			}
			echo "</table>";
			
				
		}
		?>
		<div class="pagination"><?php echo $this->pagination->create_links()?></div>
	</div>
</div>