<html>
<head>
<title>Upload Form</title>
</head>
<body>

<?php echo $error;?>

<?php echo form_open_multipart('gsma2/uploadavatar');?>

<input type="file" name="image" size="20" />

<br /><br />

<input type="submit" value="upload" />

</form>

</body>
</html>