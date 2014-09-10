<h1><?php echo $title;?></h1>


<form id="form" method="post" class="form-horizontal well" enctype="multipart/form-data">
<div class='form-group'>
	<label class="control-label">名称</label>
	<input type="text" name="title" value="<?php echo $model['title'];?>" class="form-control"  />
</div>
<div class='form-group'>
	<label class="control-label">描述</label>
	<input type="text" name="desc" value="<?php echo $model['desc'];?>" class="form-control" />
</div>
<div class='form-group'>
	<label class="control-label">海报url</label>
	<input type="text" name="posterUrl" value="<?php echo $model['posterUrl'];?>" class="form-control" />
</div>

<div class='form-group'>

	<label class="control-label">快券类型</label>
	<?php // var_dump($model);?>
	<select class="form-control" name="couponTypeId">
	<!--  <option value="2" selected>2</option>-->
	<?php 
		$couponTypeId = $model['couponType']['objectId'];
		foreach ($couponTypes as $couponType) {
			$id = $couponType['objectId'];
			$title = $couponType['title'];
			
			
			$selected = $id==$couponTypeId?"selected":"";
			echo "<option value='$id' $selected>".$title.'</option>';
		}
	?>
	
	</select>
</div>
<div class='form-group'>
	<label class="control-label">子快券类型</label>
	<select class="form-control" name="subTypeId">
	<!--  <option value="2" selected>2</option>-->
	<?php 
		$subTypeId = $model['subType']['objectId'];
		foreach ($subTypes as $couponType) {
			$id = $couponType['objectId'];
			$title = $couponType['title'];
			
			$selected = $id==$subTypeId?"selected":"";
			echo "<option value='$id' $selected>".$title.'</option>';
		}
	?>
	
	</select>
</div>

<br><br>

<h2>子商铺</h2>
 <a href="<?php echo site_url('admin/shops/createShopBranch/'.$model['objectId']);?>" class="btn btn-primary">新建子商户</a><br><br>
<table class='table table-striped table-bordered table-hover table-responsive'>
	<tr><th>编号</th><th>名称</th><th>管理</th></tr>	
	<?php 
	if (!empty($shopBranches)){
	foreach ($shopBranches as $key => $list) {

	?>
		
	<tr>
		<td><?php echo $list['objectId'];?></td>
		<td><?php echo $list['title'];?></td>
		<td align="center"><?php echo anchor('admin/shops/editShopBranch/'.$list['objectId'],'查看')." | ".anchor('admin/shops/deleteShopBranch/'.$list['objectId'].'/'.$model['objectId'],'删除');?></td>
	</tr>
		
	<?php }
	}
	?>	
</table>


<h2>优惠券</h2>
<a href="<?php echo site_url('admin/coupons/create/'.$model['objectId']);?>" class="btn btn-primary">新建优惠券</a><br><br>
<table class='table table-striped table-bordered table-hover table-responsive'>
	<tr><th>编号</th><th>名称</th><th>管理</th></tr>	
	<?php 
	if (!empty($coupons)){
	foreach ($coupons as $key => $list) {

	?>
			
	<tr>
		<td><?php echo $list['objectId'];?></td>
		<td><?php echo $list['title'];?></td>
		<td align="center"><?php echo anchor('admin/coupons/edit/'.$list['objectId'],'编辑')." | ".anchor('admin/coupons/delete/'.$list['objectId'],'删除');?></td>
	</tr>
		
	<?php }
	}
	?>	
</table>

<input type="hidden" name="id" value="<?php echo $model['objectId'];?>">
<input type="hidden" name="type" value="<?php echo $type;?>">
<input type="submit" name="" value="提交" class="btn btn-primary"  />
<a></a>
</form>