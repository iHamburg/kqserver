<!DOCTYPE html>
<html>
<head>
<!--<meta charset=“utf-8”>-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1"/>

<title><?php echo $title; ?></title>
  	
<!--  最新 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/css/bootstrap.min.css"/>

<!--  文档CSS文件 -->
<link href="<?php echo base_url('public/css/admin.css');?>" rel="stylesheet" type="text/css" />

<?php 
if(isset($css)) {
	
	foreach ($css as $cssfile) {
		echo "<link href=".$cssfile." rel='stylesheet' type='text/css' />";
	}
}
?>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
  <script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->




</head>
<body>
<div class="container">
 
  <div id="header"  class="container">
  <?php $this->load->view('templates/admin_header');?>
  </div>
   
  <div class="row">
 
	
	  <div id="main" class= "col-md-10">
	  <?php $this->load->view($main);?>

	  </div>
  
  </div>
  <div id="footer" class="container">
  	<?php $this->load->view('templates/admin_footer');?>
  </div>
  
 </div>
 
<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="http://cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/js/bootstrap.min.js"></script>
    
<?php if(isset($js)) $this->load->view($js); ?>

</body>
</html>
