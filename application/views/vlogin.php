
<nav class="navbar navbar-default" role="navigation">
 
  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="navbar-header" id="bs-example-navbar-collapse-1">
<!--    <ul class="nav navbar-nav">-->
<!--      <li class="active"><a href="#">Link</a></li>-->
<!--      <li><a href="#">Link</a></li>-->
<!--     <p class="navbar-text">Signed in as Mark Otto</p>-->
<!--    </ul>-->
     <p class="navbar-text" style="text-align:center">青岛世园会登录</p>
  </div><!-- /.navbar-collapse -->
</nav>
  <form class="well" method="post" >

	    <?php if(isset($userLoginMsg)){?>
	        <div class="alert alert-danger alert-dismissable">	
				<button type="button" class="close" data-dismiss="alert" >&times;</button>
				<?php echo $userLoginMsg; ?>
		  	</div>
	    <?php }?>
	  
	    <div class="form-group">
	   	 <input type="text" name="username" value="" id="userUsername" class="form-control" placeholder="用户名" />
	    </div>
	     <div class="form-group">
	    <input type="password" name="password" value="" class="form-control" id="userPassword" placeholder="密码" />
	    </div>
	     
	     <div class="form-group">
		<input type="hidden" name="userLoginForm" value="1">
		<button class="btn btn-primary">用户登录</button>

<!--	    <a href="#" class="btn btn-primary">注册</a>-->
	    </div>
    </form>
