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

<body>

<form action='<?php echo site_url('gd_web/login');?>' method='post' name='frm'>
<input type="hidden" name="username2" value="<?php echo $uid;?>"/>

</form>

<!-- jQuery文件。务必在bootstrap.min.js 之前引入 --> 
<script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script> 
<script src="<?php echo base_url('public/js/kq_web.js');?>"></script>
<!-- 最新的 Bootstrap 核心 JavaScript 文件 --> 
<script src="http://cdn.bootcss.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

<script>
document.frm.submit();
</script>
</body>
</html>
