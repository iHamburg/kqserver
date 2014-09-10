<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1"/>

<title><?php echo $event['name'] ?></title>
  	
<!--  最新 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/css/bootstrap.min.css"/>

<!--  文档CSS文件 -->

<link href="<?php echo base_url('public/css/jumbotron-narrow.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('public/css/event_preview.css');?>" rel="stylesheet" type="text/css" />
	
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
  <script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

</head>
<body>
<div class="container">
   <div class="jumbotron">
        <h1><?php echo $event['name']?></h1>
        <img src="<?php echo base_url($event['image'])?>">
        <br>
        <pre align="left" class="lead"><?php echo $event['description']?></pre>
        <hr>
      	<h2>活动主办</h2>
      	<p><?php echo $event['sponsor']?></p>
        <hr>
        <h2>活动时间</h2>
      	<p><?php echo $event['datetime']?></p>
      	 <hr>
        <h2>活动地点</h2>
      	<p><?php echo $event['location']?></p>
      	 <hr>
        <h2>活动费用</h2>
      	<p><?php echo $event['cost']?></p>
      	<hr>
        <h2>活动流程</h2>
      	<pre align="left"><?php echo $event['flow']?></pre>
      	<hr>
        <p class=""><?php echo $event['content']?></p>
       
<!--        <p><a class="btn btn-lg btn-success" href="#" role="button">Sign up today</a></p>-->
   </div>

	<form id="" method="post" action="<?php echo site_url('admin/events/enrollapi/'.$event['id'])?>">
		<div class="form-group">
			<label class="control-label">姓名：</label>
			<input class="form-control" name="realname" id="field_3" type="text">
		</div>
		<div class="form-group">
			<label class="control-label">性别：</label>
			<input class="" name="sex" value="男" type="radio">男
			<input class="" name="sex" value="女" type="radio">女
			
		</div>
		<div class="form-group">
			<label class="control-label" for="tel">手机：</label>
			<input autocomplete="off" required class="form-control" name="telephone" id="field_4" type="tel"/>
		</div>
		<div class="form-group">
			<label class="control-label" for="tel">微信：</label>
			<input autocomplete="off" class="form-control" name="username" id="field_2" type="tel"/>
		</div>
		<div class="form-group">
			<input type="hidden" name="eventid" value="<?php echo $event['id'];?>"></input>
            <p id="msg"></p>
            <input  class="btn btn-default" type="submit" value="submit"/>
			<input id="enroll" class="btn btn-default" type="button" value="ajax报名"/>
		</div>
 </form>
</div>
 
<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="http://cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/js/bootstrap.min.js"></script>
    
 
</body>
</html>
