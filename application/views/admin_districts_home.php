
<h1><?php echo $title;?></h1>
<div class="row"><!--
		<div class="col-md-2">
			<ul class="nav nav-pills nav-stacked">
			  <li class="active"><?php echo anchor('admin/users','一级类型');?></li>
			  <li><?php echo anchor('admin/users/create','二级类型');?></li>
			</ul>
		</div>
		--><div class="col-md-10">
<?php 	
		if($this->session->flashdata('msg')){

			echo "<div class='message'>".$this->session->flashdata('msg')."</div>";
		
		}
		?>
	

	 <a href="<?php echo site_url('admin/districts/create');?>" class="btn btn-primary">新建区域</a>

	 <br/>
	<br/>
	<?php 
		
		if(!empty($models)){
		
//			var_dump($models);
			echo "<table class='table table-striped table-bordered table-hover table-responsive'>";
			
//			$headers = array('区域编号','区域名','类型','会员姓名','注册时间','会员管理');
			$headers = array('编号','名称','子区域','管理');
			echo "<tr>";
			foreach ($headers as $header) {
				echo "<th>".$header."</th>";
			}
			echo "</tr>";
			foreach ($models as $key => $list) {
				$subtypecount = count($list['subDistricts']);
				
				## 会员分组
//				$usergroup=$list['usergroup'];
//				if($usergroup=='user'){
//					$groupStr='普通会员';
//				}
//				else if($usergroup=='vip'){
//					$groupStr='VIP会员';
//				}
//				else{
//					$groupStr='游客';
//				}
				echo "<tr>";
				echo "<td>".$list['objectId']."</td>";
				echo "<td>".$list['title']." ($subtypecount)</td>";
//				echo "<td>".$groupStr."</td>";
//				echo "<td>".$list['realname']."</td>";
				echo "<td>".anchor('admin/districts/subdistricts/'.$list['objectId'],'编辑')."</td>";
				echo "<td align='center'>".anchor('admin/districts/edit/'.$list['objectId'],'编辑')." | ".anchor('admin/districts/delete/'.$list['objectId'],'删除')."</td>";
				echo "</tr>";
				
			}
			echo "</table>";
			
				
		}
		?>
	<?php echo $this->pagination->create_links()?>
		
	
	</div>
</div>