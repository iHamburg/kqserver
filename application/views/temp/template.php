<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title><?php echo $title; ?></title>
  <link href="<?php echo base_url('public/');?>/css/default.css" rel="stylesheet" type="text/css" />
<!--  <noscript>-->
<!--Javascript is not enabled! Please turn on Javascript to use this site.-->
<!--</noscript>-->
</head>
<body>
<div id="wrapper">
 

  <div id="header">
  <?php $this->load->view('header');?>
  </div>
   <div id="nav">
  <?php $this->load->view('navigation2');?>
  </div>
  <div id="main">
  <?php $this->load->view($main);?>
  </div>
  <div id="footer">
  	<?php $this->load->view('footer');?>
  </div>
  </div>
</body>
</html>
