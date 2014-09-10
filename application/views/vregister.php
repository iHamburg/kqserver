 <form  method="post"  enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal well" id="register_form">
    	
    <h3 style="text-align:center">新用户注册</h3>
    		<?php if($this->session->flashdata('msg')){?>
		
			<div class="alert alert-warning alert-dismissable">
	  			<button type="button" class="close" data-dismiss="alert" >&times;</button>
	  			<?php echo $this->session->flashdata('msg');?>
			</div>
		
		<?php }?>
    <br>
   		 <div id="usernameGroup" class="form-group ">
			<label class="col-sm-2 control-label">用户名 <span class="label label-danger">必填</span></label>
            <div class="col-sm-10">
			<input class="form-control " name="username"  type="text"/>
			<span class="help-block" id="usernameHint"></span>
            </div>
		</div>
          <div class="form-group">
			<label class="col-sm-2 control-label">密码 <span class="label label-danger">必填</span></label>
            <div class="col-sm-10">
			<input class="form-control" name="password" type="password" id="password" required />
            </div>
		</div>
         <div class="form-group">
			<label class="col-sm-2 control-label">确认密码 <span class="label label-danger">必填</span></label>
            <div class="col-sm-10">
			<input class="form-control" name="confirm_password" type="password" required />
            </div>
		</div>
    	<div class="form-group">
			<label class="col-sm-2 control-label">姓名 </label>
            <div class="col-sm-10">
			<input class="form-control" name="realname" id="realname" type="text"  />
            </div>
		</div>
	
        <div class="form-group">
			<label class="col-sm-2 control-label">性别 </label>
             <div class="col-sm-10">
             	<div class="radio">
                	<label><input class="" name="sex" value="男" type="radio" >男</label>
                </div>
                <div class="radio">
                	<label><input class="" name="sex" value="女" type="radio" >女</label>
                </div>
            </div>		
		</div>
        
		<div class="form-group">
			<label class="col-sm-2 control-label" for="tel">手机号</label>
			 <div class="col-sm-10">
             	<input autocomplete="off"  class="form-control" name="telephone" id="telephone" type="tel"/>
               </div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="tel">微信昵称 <span class="label label-danger">必填</span></label>
            <div class="col-sm-10">
				<input autocomplete="off" class="form-control" name="wxName" id="wxName" required/>
            </div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="tel">我的名片 <span class="label label-danger">必须</span></label>
            <div class="col-sm-10">
				<input  name="businesscard" id="businesscard" type="file" required/>
            </div>
		</div>
		<br>
		<div class="form-group">
			<input id="eventid" type="hidden" name="eventid" />
         	<input type="hidden" name="callbackType" value="<?php //echo $callbackType;?>" />
			<input type="hidden" name="callbackID" value="<?php //echo $callbackID;?>" />
			<input id="enrolled" type="hidden" value=""/>
			<input type="submit"  class="btn btn-primary form-control" value="新用户注册"/>
		</div>
        
    </form>