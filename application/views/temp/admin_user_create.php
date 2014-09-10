<h1><?php echo $title;?></h1>


<form action="<?php echo current_url()?>" method="post" class="form-horizontal well" enctype="multipart/form-data">
<div class='form-group'>
	<label class="control-label">真实姓名</label>
	<input type="text" name="realname" value="" class="form-control"  />
</div>
<div class='form-group'>
	<label class="control-label">用户名</label>
	<input type="text" name="username" value="" class="form-control"  />
</div>
<div class="form-group">
			<label class="control-label">性别：</label>
			<input class="" name="sex" value="男" type="radio">男
			<input class="" name="sex" value="女" type="radio" checked>女
</div>
<div class='form-group'>
	<label class="control-label">电话</label>
	<input name="telephone" class="form-control" value="" type="tel"/>
</div>
<div class='form-group'>
	<label class="control-label">电子邮件</label>
	<input type="email" name="email" value="" class="form-control"  />
</div>
<div class='form-group'>
	<label class="control-label">用户类型</label>
	<select  class="form-control" name="usergroup">
	  <option value ="普通用户">普通用户</option>
	  <option value ="VIP用户">VIP用户</option>
	</select>
</div>

<input type="hidden" name="content" value="content" id="content"  />

<input type="submit" name="" value="提交" class="btn btn-primary"  />
</form>


