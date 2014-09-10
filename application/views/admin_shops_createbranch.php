<h1><?php echo $title;?></h1>


<form id="form" method="post" class="form-horizontal well" enctype="multipart/form-data">
<div class='form-group'>
	<label class="control-label">名称</label>
	<input type="text" name="title" value="" class="form-control"  />
</div>
<!--<div class='form-group'>-->
<!--	<label class="control-label">父类型ID</label>-->
<!--	<input type="text" name="parentId" value="<?php echo empty($parentId)?'':$parentId;?>" class="form-control" />-->
<!--</div>-->
<div class='form-group'>
	<label class="control-label">营业时间</label>
	<input type="text" name="openTime" class="form-control"  />
</div>
<div class='form-group'>
	<label class="control-label">电话</label>
	<input type="text" name="phone" class="form-control"  />
</div>
<div class='form-group'>
	<label class="control-label">地址</label>
	<input type="text" name="address" class="form-control"  />
</div>
<div class='form-group'>
	<label class="control-label">店铺坐标</label><br>
	<label class="control-label">latitude</label>
	<input type="text" name="latitude" class="form-control"  />
	<label class="control-label">longitude</label>
	<input type="text" name="longitude" class="form-control"  />
</div>

<div class='form-group'>
	<label class="control-label">区域</label>
	<select class="form-control" name="districtId">
	<!--  <option value="2" selected>2</option>-->
	<?php 
		foreach ($headDistricts as $obj) {
			$id = $obj['objectId'];
			$title = $obj['title'];
	
			echo "<option value='$id'>".$title.'</option>';
		}
	?>
	
	</select>
</div>
<div class='form-group'>
	<label class="control-label">子区域</label>
	<select class="form-control" name="subDistrictId">
	<!--  <option value="2" selected>2</option>-->
	<?php 
		foreach ($subDistricts as $obj) {
			$id = $obj['objectId'];
			$title = $obj['title'];
	
			echo "<option value='$id'>".$title.'</option>';
		}
	?>
	
	</select>
</div>
<div class="checkbox">
    <label>
      <input type="checkbox" name="continuous" checked> 连续输入
    </label>
</div>

<br><br>
<input type="hidden" name="parentId" value="<?php echo $parentId;?>" />
<input type="submit" name="" value="提交" class="btn btn-primary"  />
<a></a>
</form>


