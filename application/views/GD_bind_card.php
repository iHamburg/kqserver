<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title><?php echo $title;?></title>
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url('public/css/min_web.css');?>">
</head>
<style>
body{
	margin:0px auto;
	background-color:rgba(245,239,217,1);
}
</style>
<body>
<div class="container-fluid">
<div class="row">
<div>
<img src="<?php echo base_url('public/images/p3/p3_pic1.jpg');?>" width="100%">
</div>

	<p id="p" class="col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 col-md-10 col-md-offset-1"><img src="<?php echo base_url('public/images/p3/p3_!.png');?>" width="8%">只需一步即可享用3元超值快券</p>

<div class="col-sm-12 col-xs-12 location" >
<form id="form" method="post" enctype="multipart/form-data">
<div class='form-group col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 col-md-10 col-md-offset-1'>
	<input style="border:none" type="text" name="cardNumber" class="form-control instype input" placeholder="请输入光大信用卡卡号" />
	<input type="hidden" name="uid" class="form-control instype input" value="<?php echo $uid;?>" />
	<input type="hidden" value="<?php echo $uid?>"  name="username2" />
	<input type="hidden" name="username3" value="1"/>
</div>
<div class='form-group col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 col-md-10 col-md-offset-1 ma'>
	<input class="btn btn-danger bw instype submit" type="submit" id="btn" value="立即领取" />
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
