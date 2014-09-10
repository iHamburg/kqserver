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
	<select class="form-control" name="couponTypeId">
	<!--  <option value="2" selected>2</option>-->
	<?php 
		foreach ($couponTypes as $couponType) {
			$id = $couponType['objectId'];
			$title = $couponType['title'];
	
			echo "<option value='$id'>".$title.'</option>';
		}
	?>
	
	</select>
</div>
<div class='form-group'>
	<label class="control-label">快券子类型</label>
	<select class="form-control" name="subTypeId">
	<!--  <option value="2" selected>2</option>-->
	<?php 
		foreach ($subTypes as $couponType) {
			$id = $couponType['objectId'];
			$title = $couponType['title'];
	
			echo "<option value='$id'>".$title.'</option>';
		}
	?>
	
	</select>
</div>

<br><br>
<input type="submit" name="" value="提交" class="btn btn-primary"  />
<a></a>
</form>


