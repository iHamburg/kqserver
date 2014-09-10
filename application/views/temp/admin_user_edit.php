<h1><?php echo $title;?></h1>


<form action="<?php echo current_url()?>" method="post" class="form-horizontal well" enctype="multipart/form-data">
<div class='form-group'>
	<label class="control-label">真实姓名</label>
	<input type="text" name="realname" value="<?php echo $user['realname']?>" class="form-control"  />
</div>
<div class='form-group'>
	<label class="control-label">用户名</label>
	<input type="text" name="username" value="<?php echo $user['username']?>" class="form-control"  />
</div>
<div class="form-group">
			<label class="control-label">性别：</label>
			<input class="" name="sex" value="男" type="radio" <?php echo $user['sex']=='男'?'checked':""?>>男
			<input class="" name="sex" value="女" type="radio" <?php echo $user['sex']=='女'?'checked':""?>>女
</div>
<div class='form-group'>
	<label class="control-label">电话</label>
	<input name="telephone" class="form-control" value="<?php echo $user['telephone']?>" type="tel"/>
</div>
<div class='form-group'>
	<label class="control-label">电子邮件</label>
	<input type="email" name="email" value="<?php echo $user['email']?>" class="form-control"  />
</div>
<div class='form-group'>
	<label class="control-label">用户类型</label>
	<select  class="form-control" name="usergroup">
	  <option value ="普通用户" <?php echo $user['usergroup']=='普通用户'?'selected':""?>>普通用户</option>
	  <option value ="VIP用户" <?php echo $user['usergroup']=='VIP用户'?'selected':""?>>VIP用户</option>
	</select>
</div>

<input type="hidden" name="content" value="content" id="content"  />
<input type="hidden" name="id" value="<?php echo $user['id']?>" />
<input type="submit" name="" value="提交" class="btn btn-primary"  />
</form>


