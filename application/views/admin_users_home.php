
<h1><?php echo $title;?></h1>
<div class="row"><div class="col-md-10">
<?php 	
		if($this->session->flashdata('msg'))
			echo "<div class='message'>".$this->session->flashdata('msg')."</div>";
		
?>

<!--	 <a href="<?php echo site_url('admin/shops/create');?>" class="btn btn-primary">新建商户</a>-->

	<br/><br/>
	

	<table class='table table-striped table-bordered table-hover table-responsive'>
	<tr><th>编号</th><th>昵称</th><th>手机号</th><th>收藏的优惠券</th><th>收藏的商户</th><th>管理</th></tr>	
	<?php 
	
//	var_dump($models);
	
	foreach ($models as $key => $list) {
		$favoritedCouponsCount = count($list['favoritedCoupons']);
		$favoritedShopsCount = count($list['favoritedShops']);
	?>
		
	<tr>
		<td><?php echo $list['objectId'];?></td>
		<td><?php echo $list['nickname'];?></td>
		<td><?php echo $list['phone'];?></td>
		<td><?php echo anchor('admin/users/edit/'.$list['objectId'], $favoritedCouponsCount);?></td>
		<td><?php echo anchor('admin/users/edit/'.$list['objectId'], $favoritedShopsCount);?></td>
		<td align="center"><?php echo anchor('admin/users/edit/'.$list['objectId'],'编辑');?></td>
	</tr>
		
	<?php }?>	
	</table>
	
	<?php echo $this->pagination->create_links()?>
		
	
	</div>
</div>