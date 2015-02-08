<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<meta name="viewport" content="user-scalable=0" />
<title><?php echo $title;?></title>
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url('public/css/min_web.css');?>">
</head>
<style>
body{
	
	background-color:rgba(245,239,217,1);
}
</style>
<body>
<div class="container-fluid">
<div class="row">
<div>
<img src="<?php echo base_url('public/images/p2/p2_pic.jpg');?>" width="100%">
</div>
<div class="col-sm-12 col-xs-12 location" >
<form id="form" method="post" enctype="multipart/form-data">
<div class='form-group col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 col-md-10 col-md-offset-1'>
	<input style="border:none" type="text" name="username" id="moblie"  class="form-control instype input" placeholder="请输入领取快券的手机号"/>
</div>
<div class='form-group col-sm-6 col-sm-offset-1 col-xs-6 col-xs-offset-1 col-md-6 col-md-offset-1 ma'>
	<input style="border:none" type="text" name="verificationCode" class="form-control instype input" placeholder="请输入验证码"/>
	<input type="hidden" value="m" id="hidd" name="verificationCode2" />
	<input type="hidden" value="<?php echo $uid?>"  name="username2" />
	<input type="hidden" name="username3" value="1"/>
</div>
<div class='form-group col-sm-4 col-xs-4 col-md-4 ma'>
	<input class="btn btn-warning instype submit2 wid" type="button" id="btn" value="获取验证码" />
</div>
<div id="an" class='form-group col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 col-md-10 col-md-offset-1'>
	<label>
      <input class="style" type="checkbox" name="agree" checked>&nbsp; <span id="sp">我已阅读并同意<a href="http://www.quickquan.com/agreement.html">《快券注册协议》</a></span>
    </label>
</div>
<div class='form-group col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 col-md-10 col-md-offset-1'>
	<input class="btn btn-danger bw instype submit" type="submit"  value="立即领取" />
</div>
</form>

</div>
</div>
</div>


<!-- jQuery文件。务必在bootstrap.min.js 之前引入 --> 
<script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script> 
<script src="<?php echo base_url('public/js/kq_web.js');?>"></script>
<!-- 最新的 Bootstrap 核心 JavaScript 文件 --> 
<script src="http://cdn.bootcss.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>



</body>
</html>
