
	
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
