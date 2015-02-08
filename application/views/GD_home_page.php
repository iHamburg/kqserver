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
	background-image:url(<?php echo base_url('public/images/p1/p1_bg.jpg');?>);
	 background-size:cover;
}
</style>
<body>
<div class="container-fluid ">

  <div class="row ">
    <div class="col-sm-12 self">
     <a id="ddd" class="col-sm-8 col-xs-8 col-sm-offset-2 col-xs-offset-2 " href="<?php echo site_url('gd_web/beforeLogin');?>">
    <img src="<?php echo base_url('public/images/p1/p1_btn.png');?>" width="100%"></a> </div>
   
  </div>
</div>
<!-- jQuery文件。务必在bootstrap.min.js 之前引入 --> 
<script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script> 

<!-- 最新的 Bootstrap 核心 JavaScript 文件 --> 
<script src="http://cdn.bootcss.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>


</body>
</html>
