<h1><?php echo $title;?></h1>



<form id="form" method="post" class="form-horizontal well" enctype="multipart/form-data">
<div class='form-group'>
	<label class="control-label">名称</label>
	<input type="text" name="title" value="" class="form-control"  />
</div>
<div class='form-group'>
	<label class="control-label">折扣</label>
	<input type="text" name="discountContent" class="form-control" />
</div>
<div class='form-group'>
	<label class="control-label">使用说明</label>
	<input type="text" name="usage" class="form-control" />
</div>
<div class='form-group'>
	<label class="control-label">有效期</label>
	<input type="text" name="validate" class="form-control" />
</div>
<div class='form-group'>
	<label class="control-label">图片地址</label>
	<input type="text" name="avatarUrl" class="form-control" />
</div>

<div class='form-group'>
	<label class="control-label">商户</label>
	<select class="form-control" name="shopId">
	<!--  <option value="2" selected>2</option>-->
	<?php 
		foreach ($shops as $shop) {
			$id = $shop['objectId'];
			$title = $shop['title'];
	
			echo "<option value='$id'>".$title.'</option>';
		}
	?>
	
	</select>
</div>

<br><br>


<input type="submit" name="" value="提交" class="btn btn-primary"  />
<a></a>
</form>


