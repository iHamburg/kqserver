<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1"/>

<title><?php echo $event['name'] ?></title>
  	
<!--  最新 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/css/bootstrap.min.css"/>

<!--  文档CSS文件 -->
<link href="<?php echo base_url('public/css/jquery.alert.css');?>" rel="stylesheet" type="text/css" />
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
   <div class="">
        <p class="title"><?php echo $event['name']?></p>
        <img src="<?php echo base_url($event['image'])?>">
        <br>
        <pre align="left" class=""><?php echo $event['description']?></pre>
        <hr>
      	<h4>活动主办</h4>
      	<p><?php echo $event['sponsor']?></p>
        <hr>
        <h4>活动时间</h4>
      	<p><?php echo $event['datetime']?></p>
      	 <hr>
        <h4>活动地点</h4>
      	<p><?php echo $event['location']?></p>
      	 <hr>
        <h4>活动费用</h4>
      	<p class="small"><?php echo $event['cost']?></p>
      	<hr>
        <h4>活动流程</h4>
      	<pre align="left"><?php echo $event['flow']?></pre>
      	<hr>
        <p class=""><?php echo $event['content']?></p>
       
<!--        <p><a class="btn btn-lg btn-success" href="#" role="button">Sign up today</a></p>-->
   </div>

<div id="enrollhistory">
<small>已有<?php echo $applicantsnumber;?>人报名</small>
<table class='table  table-bordered table-hover table-responsive'>
	<?php 
		if($applicantsnumber>0){
			foreach ($applicants as $applicant) {
	?>
			<tr>
				<td><?php  echo empty($applicant['realname'])?'匿名':$applicant['realname']?></td>
				<td align="right"><?php echo transTime($applicant['enroll_time'])?></td>
			</tr>		
	<?php 
			}
		}
	?>
</table>
</div>

<div class="countdown">                        
	<p>报名剩余时间</p>                            
	<div class="cc">
		<div class="cd">
		  	<div><span>totalHours</span><i>时</i></div><div class="dot">:</div>			
             <div><span>%M</span><i>分</i></div>
             <div class="dot">:</div><div><span>%S</span><i>秒</i></div>
             <div class="dot">:</div>
         </div>
							<div><span class="ms"></span></div>
							</div>
</div>

	
	<form id="enrollform" method="post" action="<?php echo current_url()?>">
		<h2 align="center">我要报名</h2>
		<div class="form-group">
			<label class="control-label">姓名：<span class="label label-danger">必填</span></label>
			<p id="realnamehint" class="text-danger"><p>
			<input class="form-control" name="realname" id="realname" type="text" value="<?php echo isset($user)?$user['realname']:''?>" check-type="required" required-message="密码不能为空！"/>
		</div>
		<div class="form-group">
			<label class="control-label">性别：</label>
			<input class="" name="sex" value="男" type="radio" <?php if(isset($user)){
				if($user['sex']=='男')
					echo 'checked';
			}?>>男
			<input class="" name="sex" value="女" type="radio" <?php if(isset($user)){
				if($user['sex']=='女')
					echo 'checked';
			}else{
				echo 'checked';
			}?>>女
			
		</div>
		<div class="form-group">
			<label class="control-label" for="tel">手机：</label>
			<input autocomplete="off" value="<?php echo isset($user)?$user['telephone']:''?>" required class="form-control" name="telephone" id="telephone" type="tel"/>
		</div>
		<div class="form-group">
			<label class="control-label" for="tel">微信：</label>
			<input autocomplete="off" class="form-control" name="username" id="username" value="<?php echo isset($user)?$user['username']:''?>"/>
		</div>
		<div class="form-group">
			<input id="eventid" type="hidden" name="eventid" value="<?php echo $event['id'];?>"/>
            <p id="msg"></p>
<!--            <input class="btn btn-default" type="submit" value="submit"/>-->
			<input id="enrolled" type="hidden" value="<?php echo isset($enrolled)?$enrolled:'0'?>"/>
			<input id="enrollbtn" class="btn btn-primary btn-block" type="button" value="报名"/>
		</div>
 	</form>
 	
 		<h3 class="text-success" id="enrollhint"></h3>
  	<div id="qr">
 		<?php if(!empty($event['qrimage'])){
 			?>
 			
 			<p>扫描二维码加入群聊<br/>加群方法：将上面的图片保存至相册，然后打开微信的扫一扫功能，选择相册中刚保存的图片就可以了~</p>
 			<img src="<?php echo base_url($event['qrimage'])?>"/>
 			<?php 
 		}
 		?>
 		
 	</div>
 	
 	 <footer class="footer" >
    
      <p>Powered By <a href="http://www.xappsoft.de/cn/" target="_blank" title="Xappsoft">Xappsoft Technologie</a></p>
    
    </footer>
</div>


 
<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="http://cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/js/bootstrap.min.js"></script>

<!-- for alert-->
<script src="http://keleyi.com/keleyi/pmedia/jquery/ui/1.10.3/js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>

<!-- for Countdown-->
<script src="<?php echo base_url('public/js/jquery.countdown.js')?>"></script>
<script src="<?php echo base_url('public/js/jquery.alert.js')?>"></script>    
<script>

$(function(){

	var enrolled=$('#enrolled').val();
	if(enrolled>0){
		$('#enrollhint').html('已经报过名');
		$('#enrollbtn').hide();
	}
	else{
		$('#qr').hide();
	}

//	$('#txt1').keyup(function(){
//
//		var str = $(this).val();
//		$('#txtHint').load("gethint.php?q="+str);
//
//	});

	$('#enrollbtn').click(function(){

			var eventid=$('#eventid').val();
			var realname = $('#realname').val();
			var sex= $('input[name="sex"]:checked').val();
			var username= $('#username').val();
			var telephone= $('#telephone').val();

			if(realname.length==0){
				$('#realnamehint').html('姓名不能为空')
			}else{
				$('#realnamehint').html('')
				 $.post("<?php echo $enroll_api?>",{
			         realname:realname,
			         telephone:telephone,
			         username:username,
			         sex:sex,
			         eventid:eventid
			         },
			      function(data,status){
					      
//			         alert("Status: " + data.status + "\nMsg: " + data.msg);
//			           $('#txtHint').html(data);
//			           alert('提交成功，谢谢参与');
					if(data.status=='ok'){
					  $('#qr').show();
				      $('#enrollhint').html(data.msg);
					}else{
						$('#enrollhint').html('操作错误,稍后再试');
					}
			      });
			}
 
	})
 	
});

//-- Countdown
$(function(){   
        	
			
	var ms = {
		msStart : 99,
		msDown : function(){
			if(this.msStart < 10){
				$('.ms').text( '0' + this.msStart);
			}
			else{
				$('.ms').text(this.msStart);
			}			
			this.msStart--;
			if(this.msStart < 0){
				this.msStart = 99;
			}
		}
	}
	
	var sh = setInterval(function(){ms.msDown()},10.1);
	$('.cd').countdown('2014/01/25 00:00', function(event) {
		var totalHours = event.offset.totalDays * 24 + event.offset.hours;
		if(totalHours < 10){
			totalHours = '0' + totalHours;
		}
	    $(this).html(event.strftime('<div><span>' + totalHours + '</span><i>时</i></div>'
									+'<div class="dot">:</div>'
									+'<div><span>%M</span><i>分</i></div>'
									+'<div class="dot">:</div>'
									+'<div><span>%S</span><i>秒</i></div>'
									+'<div class="dot">:</div>'));
	}).on('finish.countdown', function(){
		$(this).parents(".countdown").slideUp();
		$('.price').hide();
		$('.fa').hide();
		$('.op').show();
	});   
    });

</script>
 
</body>
</html>
