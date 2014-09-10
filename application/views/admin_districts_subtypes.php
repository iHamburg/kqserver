
<h1><?php echo $title;?></h1>
<div class="row">
		
		<div class="col-md-10">


	 <a href="<?php echo site_url("admin/districts/create/$parentId");?>" class="btn btn-primary">新建子区域</a>

	 <br/>
	<br/>
	<?php 
//		var_dump($parentId);
		if(!empty($models)){
		
			
			echo "<table class='table table-striped table-bordered table-hover table-responsive'>";
			
//			$headers = array('区域编号','区域名','类型','会员姓名','注册时间','会员管理');
			$headers = array('编号','名称','管理');
			echo "<tr>";
			foreach ($headers as $header) {
				echo "<th>".$header."</th>";
			}
			echo "</tr>";
			foreach ($models as $key => $list) {
				$id = $list['objectId'];
//				var_dump($list);
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
				echo "<td>".$list['title']."</td>";
//				echo "<td>".$groupStr."</td>";
//				echo "<td>".$list['realname']."</td>";
//				echo "<td>".anchor('admin/coupontypes/subtypes/'.$list['objectId'],'编辑')."</td>";
				echo "<td align='center'>".anchor('admin/districts/edit/'.$list['objectId'],'编辑')." | ".anchor("admin/districts/delete/$id/$parentId",'删除')."</td>";
				echo "</tr>";
				
			}
			echo "</table>";
			
				
		}
		?>

		
	
	</div>
</div>