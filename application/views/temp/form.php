<!DOCTYPE html>
<html>
<head>
	<title>HTML模版</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;"  />
	<meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    
	<link href="css/upload.css" type="text/css" rel="stylesheet" />
	<style>
	  .thumb {
	    height: 50px;
	   }
	   body
	  {
	  	background-color:#eeeeee;
	  }
	</style>
	<script type="text/javascript" src="upload/lib/klass.min.js"></script>
	<script type="text/javascript">
		(function(window, PhotoSwipe){
			document.addEventListener('DOMContentLoaded', function(){
				var options = {},
					instance = PhotoSwipe.attach( window.document.querySelectorAll('#Gallery a'), options );
			
			}, false);
			
		}(window, window.Code.PhotoSwipe));
		
	</script>
  
</head>
<body>
<h1>Form</h1>
<?php
//$hidden = array('member_id' => '234');
	echo form_open('hello/showform','',array('hidden'=>'hidden'));
	$data = array(
              'name'        => 'username',
              'id'          => 'username',
              'value'       => 'johndoe',
              'maxlength'   => '100',
              'size'        => '50',
              'style'       => 'width:50%'
            );

	echo form_input($data).'<br/>';
	echo form_password('pass','').'<br/>';
	echo form_textarea('textarea','default').'<br/>';
	$options = array(
                  'small'  => 'Small Shirt',
                  'med'    => 'Medium Shirt',
                  'large'   => 'Large Shirt',
                  'xlarge' => 'Extra Large Shirt',
                );

	$shirts_on_sale = array('small', 'large');
	echo form_dropdown('shirts', $options, 'large').'<br/>';
	
//	echo form_dropdown('shirts', $options, $shirts_on_sale);

	echo form_fieldset('Address Information');
echo "<p>fieldset content here</p>\n";
echo "<p>fieldset content here</p>\n";
echo form_fieldset_close(); 
	?>
  <p>First name: <input type="text" name="fname" /></p>
  <p>Last name: <input type="text" name="lname" /></p>
 
  <!--
  <?php echo form_hidden('username', 'johndoe');?>
  -->
  
  
  <input type="submit" value="Submit" />
</form>
</body>
</html>
