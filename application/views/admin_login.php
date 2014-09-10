<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
  
<meta name="viewport" content="width=device-width,initial-scale=1"/>

<!--  最新 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/css/bootstrap.min.css"/>

<!--  独立CSS文件 -->
 <link href="<?php echo base_url('public/');?>/css/admin.css" rel="stylesheet" type="text/css" />

<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="http://cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/js/bootstrap.min.js"></script>

</head>
<body>
<div class="container">
	
	<div class="container" style="width: 320px;">
   <h3><?php echo $title;?></h3>
 
<?php 
if($this->session->flashdata('error')){
	echo "<div class='lead msg'>".$this->session->flashdata('error')."</div>"; // css 中只需要设定.msg就可以了
}


$udata = array('name'=>'username','id'=>'u');
$pdata = array('name'=>'password','id'=>'p');


echo form_open("admin/dashboard/login",array('class'=>'well'));
echo "<p><label for='u'  >管理员用户名</label><br/>";
echo form_input($udata) . "</p>";
echo "<p><label for='p'>密码</label><br/>";
echo form_password($pdata) . "</p>";
echo form_submit(array('class'=>"btn btn-primary"),'登陆');
//echo 
echo form_close();

?>
</div>

</div>
</body>