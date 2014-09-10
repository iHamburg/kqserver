
<a href="<?php echo base_url();?>">
<img src="<?php echo base_url('public/images/cat.jpg');?>" border="0" width = "50"/>
</a>

<div id='globalnav'>
<ul>
<?php
if ($this->uri->segment(2) != "index"){
	echo "<li>".anchor("welcome/home","home")."</li>";
}
?>
<li><?php echo anchor("welcome/pages/about_us","about us");?></li>
<li><?php echo anchor("welcome/pages/contact", "contact");?></li>
<?php 
if (isset($_SESSION['cart']) && count($_SESSION['cart'])){
	echo "<li>". anchor("welcome/cart", "view cart") . "</li>";
}
?>


<li>

<?php 
echo form_open("welcome/search");
$data = array(
  "name" => "term",
  "id" => "term",
  "maxlength" => "64",
  "size" => "15"
);
echo form_input($data);
echo form_submit("submit","search");
echo form_close();
?>
</li>
<?php 
if(!isset($_SESSION['username'])){
	echo anchor('welcome/verify','login');	
}
else{

	echo anchor('welcome/home','logout'); 
}
?>
</ul>
</div>

