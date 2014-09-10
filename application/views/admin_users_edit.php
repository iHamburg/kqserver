<h1><?php echo $title;?></h1>


<form id="form" method="post" class="form-horizontal well" enctype="multipart/form-data">
<div class='form-group'>
	<label class="control-label">昵称</label>
	<input type="text" name="nickname" value="<?php echo $model['nickname'];?>" class="form-control"  />
</div>
<div class='form-group'>
	<label class="control-label">手机号</label>
	<input type="text" name="phone" value="<?php echo $model['phone'];?>" class="form-control" />
</div>


<br><br>
<h2>下载的快券</h2>
<table class='table table-striped table-bordered table-hover table-responsive'>
	<tr><th>编号</th><th>名称</th><th>管理</th></tr>	
	<?php 
	if (!empty($downloadedCoupons)){
	foreach ($downloadedCoupons as $key => $list) {
//		var_dump($list);
	?>
		
	<tr>
		<td><?php echo $list['objectId'];?></td>
		<td><?php echo $list['title'];?></td>
		<td align="center"><?php echo anchor('admin/coupons/edit/'.$list['objectId'],'查看');?></td>
	</tr>
		
	<?php }
	}
	?>	
</table>

<h2>收藏的快券</h2>
<table class='table table-striped table-bordered table-hover table-responsive'>
	<tr><th>编号</th><th>名称</th><th>管理</th></tr>	
	<?php 
	if (!empty($favoritedCoupons)){
	foreach ($favoritedCoupons as $key => $list) {

	?>
		
	<tr>
		<td><?php echo $list['objectId'];?></td>
		<td><?php echo $list['title'];?></td>
		<td align="center"><?php echo anchor('admin/coupons/edit/'.$list['objectId'],'查看');?></td>
	</tr>
		
	<?php }
	}
	?>	
</table>


<h2>收藏的商户</h2>

<table class='table table-striped table-bordered table-hover table-responsive'>
	<tr><th>编号</th><th>名称</th><th>管理</th></tr>	
	<?php 
	
	if (!empty($favoritedShops)){
	foreach ($favoritedShops as $key => $list) {

	?>
			
	<tr>
		<td><?php echo $list['objectId'];?></td>
		<td><?php echo $list['title'];?></td>
		<td align="center"><?php echo anchor('admin/shops/edit/'.$list['objectId'],'查看');?></td>
	</tr>
		
	<?php }
	}
	?>	
</table>

<h2>绑定的银行卡</h2>

<table class='table table-striped table-bordered table-hover table-responsive'>
	<tr><th>编号</th><th>卡号</th></tr>	
	<?php 
//	var_dump($cards);
//	echo $cards;
	if (!empty($cards)){
	foreach ($cards as $key => $list) {

	?>
			
	<tr>
		<td><?php echo $list['objectId'];?></td>
		<td><?php echo $list['title'];?></td>
<!--		<td align="center"><?php echo anchor('admin/shops/edit/'.$list['objectId'],'查看');?></td>-->
	</tr>
		
	<?php }
	}
	?>	
</table>

<input type="hidden" name="id" value="<?php echo $model['objectId'];?>">
<input type="hidden" name="type" value="<?php echo $type;?>">
<!--<input type="submit" name="" value="提交" class="btn btn-primary"  />-->
<a></a>
</form>