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
body {
	background-color:rgba(245, 239, 217, 1);
}
</style>
<body>
<div class="container-fluid">
  <div class="row">
    <div> <img src="<?php echo base_url('public/images/p4/p4_pic1.jpg');?>" width="100%"> </div>
    <div class="col-sm-12 col-xs-12 location" >
      <div class='form-group col-sm-10 col-sm-offset-1' >
      <?php if(!empty($card)){ ?>
      	<?php foreach ($card as $v){?>
        <div id="logo"  class="col-sm-12" style="background:#FFF">
          <div class="col-sm-4 col-xs-4 col-md-4"> <img id="bankLogo" src="<?php echo $v['logoUrl'];?>" width="125%"> </div>
          <div id="big" class="com-ms-8 com-xs-8 com-md-8">
          <div>
            <p id="p1"><?php echo $v['bankTitle'];?></p>
            
            <?php

            $num = substr($v['title'] , 0,4);
            $num2 = substr($v['title'] ,-4);
            $cardnumber = $num."**** ****".$num2;
            ?>
            
            <p id="p2"><?php echo $cardnumber;?></p>
            </div>
          </div>
        </div>
        <?php }?>
        <?php }?>
      </div>
      <div class='form-group col-sm-10 col-sm-offset-1 ma'> <a href="http://www.quickquan.com/mobile/index.html"><img src="<?php echo base_url('public/images/p4/p4_btn1.png');?>" width="100%"></a> </div>
      <div class='form-group col-sm-10 col-sm-offset-1 ma'> <a id="kk"><img src="<?php echo base_url('public/images/p4/p4_btn2.png');?>" width="100%"></a> </div>
      <div id="mask" class="col-md-12 col-xs-12 col-sm-12">
      	<img id="sd" src="<?php echo base_url('public/images/p4/share.png');?>" width="75%">
      </div>
      <div id="quick" class='form-group col-sm-6 col-sm-offset-3 '>
        <div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-xs-6 col-xs-offset-3 "> <a id="cc" ><img src="<?php echo base_url('public/images/p4/11.png');?>" width="100%"></a> </div>
      </div>
      
      
       <div>
          <div class='mab'> <img src="<?php echo base_url('public/images/p4/p4_pic4.png');?>" width="100%"> </div>
          <div class='mab'> <img src="<?php echo base_url('public/images/p4/p4_pic5.png');?>" width="100%"> </div>
          <div id="lest" class='mab'> <img src="<?php echo base_url('public/images/p4/p4_pic6.png');?>" width="100%"> </div>
        </div>
        <div class='form-group col-sm-10 col-sm-offset-1 ma'> <a href="http://www.quickquan.com/mobile/index.html"><img src="<?php echo base_url('public/images/p4/p4_btn3.png');?>" width="100%"></a> </div>
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
