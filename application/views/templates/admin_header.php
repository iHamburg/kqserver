

<nav class="navbar navbar-default" >
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
<!--    <a class="navbar-brand" href="<?php echo site_url('admin/dashboard');?>">Dashboard</a>-->
	<?php echo anchor('admin/dashboard','快券后台管理系统',array('class'=>'navbar-brand'))?>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">   
 	   <li ><?php echo anchor('admin/users','用户');?></li>
       <li ><?php echo anchor('admin/coupons','优惠券');?></li>
       <li ><?php echo anchor('admin/shops','商户');?></li>
	   <li ><?php echo anchor('admin/districts','地区');?></li>
	   <li ><?php echo anchor('admin/coupontypes','类型');?></li>
<!--		 <li class="dropdown">-->
<!--        <a href="#" class="dropdown-toggle" data-toggle="dropdown">微信管理 <b class="caret"></b></a>-->
<!--        <ul class="dropdown-menu">-->
<!--         <li><a href="<?php echo site_url('admin/gzhs/')?>">公众帐号管理</a></li>-->
<!--         <li><a href="<?php echo site_url('admin/gzhs/getmenu')?>">查看自定义菜单</a></li>-->
<!--         <li><a href="<?php echo site_url('admin/gzhs/createmenu')?>">创建自定义菜单</a></li>-->
<!--          <li><a href="<?php echo site_url('admin/gzhs/deletemenu')?>">删除自定义菜单</a></li>-->
<!--          <li class="divider"></li>-->
<!--          <li><a href="#">Separated link</a></li>-->
<!--          <li class="divider"></li>-->
<!--          <li><a href="#">One more separated link</a></li>-->
<!--        </ul>-->
<!--      </li>-->

    
    </ul>

    <ul class="nav navbar-nav navbar-right">
  	<li><?php echo anchor('admin/dashboard/logout','登出');?></li>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>
