<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
 </head>
  <body>
<script>
	<?php if($on_dialog){?>
		alert("<?php echo $dialog_msg;?>");
		<?php }?>
	location.href = "<?php echo $redirect_url;?>"
</script>
  </body>
</html>