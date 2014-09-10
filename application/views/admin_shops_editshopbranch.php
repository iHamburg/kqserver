<h1><?php echo $title;?></h1>


<form id="form" method="post" class="form-horizontal well" enctype="multipart/form-data">
<div class='form-group'>
	<label class="control-label">名称</label>
	<input type="text" name="title" value="<?php echo $model['title'];?>" class="form-control"  />
</div>

<div class='form-group'>
	<label class="control-label">营业时间</label>
	<input type="text" name="openTime" value="<?php echo $model['openTime'];?>" class="form-control"  />
</div>
<div class='form-group'>
	<label class="control-label">电话</label>
	<input type="text" name="phone" value="<?php echo $model['phone'];?>" class="form-control"  />
</div>
<div class='form-group'>
	<label class="control-label">地址</label>
	<input type="text" name="address" value="<?php echo $model['address'];?>" class="form-control"  />
</div>
<div class='form-group'>
	<label class="control-label">店铺坐标</label><br>
	<label class="control-label">latitude</label>
	<input type="text" name="latitude" value="<?php echo $model['location']['latitude'];?>" class="form-control"  />
	<label class="control-label">longitude</label>
	<input type="text" name="longitude" value="<?php echo $model['location']['longitude'];?>" class="form-control"  />
</div>

<div class='form-group'>
	<label class="control-label">区域</label>

	<select class="form-control" name="districtId">
	<!--  <option value="2" selected>2</option>-->
	<?php
	
		$districtId = $model['district']['objectId']; 
		foreach ($headDistricts as $obj) {
			$id = $obj['objectId'];
			$title = $obj['title'];
		
			$selected = $id==$districtId?"selected":"";
			echo "<option value='$id' $selected>".$title.'</option>';
		}
	?>
	
	</select>
</div>
<div class='form-group'>
	<label class="control-label">子区域</label>
	<select class="form-control" name="subDistrictId">
	<!--  <option value="2" selected>2</option>-->
	<?php 
		$subDistrictId = $model['subDistrict']['objectId'];
		foreach ($subDistricts as $obj) {
			$id = $obj['objectId'];
			$title = $obj['title'];
		
			$selected = $id==$subDistrictId?"selected":"";
			echo "<option value='$id' $selected>".$title.'</option>';
		}
	?>
	
	</select>
</div>

<br><br>
<input type="hidden" name="parentId" value="<?php echo $parentId;?>" />
<input type="submit" name="" value="提交" class="btn btn-primary"  />
<a></a>
</form>


