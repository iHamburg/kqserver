<div id="pleft">
<h2>Please login</h2>

<?php 

if($this->session->flashdata('error')){
	echo "<div class='message'>".$this->session->flashdata('error')."</div>";
}


$udata = array('name'=>'username','id'=>'u','size'=>15);
$pdata = array('name'=>'password','id'=>'p','size'=>15);


echo form_open("welcome/verify");
echo "<p><label for='u'>Username</label><br/>";
echo form_input($udata) . "</p>";
echo "<p><label for='p'>Password</label><br/>";
echo form_password($pdata) . "</p>";
echo form_submit('submit','login');
echo form_close();

?>

</div>