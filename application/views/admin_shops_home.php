
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
		if($this->session->flashdata('msg'))
			echo "<div class='message'>".$this->session->flashdata('msg')."</div>";
		
?>

	 <a href="<?php echo site_url('admin/shops/create');?>" class="btn btn-primary">新建商户</a>

	<br/><br/>
	

	<table class='table table-striped table-bordered table-hover table-responsive'>
	<tr><th>编号</th><th>名称</th><th>子商户</th><th>优惠券</th><th>管理</th></tr>	
	<?php 
	foreach ($models as $key => $list) {
		$shopBranchesCount = count($list['shopBranches']);
		$couponsCount = count($list['coupons']);
	?>
		
	<tr>
		<td><?php echo $list['objectId'];?></td>
		<td><?php echo $list['title'];?></td>
		<td><?php echo anchor('admin/shops/edit/'.$list['objectId'], $shopBranchesCount);?></td>
		<td><?php echo anchor('admin/shops/edit/'.$list['objectId'], $couponsCount);?></td>
		<td align="center"><?php echo anchor('admin/shops/edit/'.$list['objectId'],'编辑')." | ".anchor('admin/shops/delete/'.$list['objectId'],'删除');?></td>
	</tr>
		
	<?php }?>	
	</table>
	
	<?php echo $this->pagination->create_links()?>
		
	
	</div>
</div>