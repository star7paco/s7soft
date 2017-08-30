<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<?php echo Asset::css('bootstrap.css'); ?>
</head>

<body>

	<div class="row">
	<div class="col-sm-6 col-sm-offset-3">

		<img width="200" alt="" src="../assets/img/logo_02_black02.png">
		<h1>Tokyo Restaurant Week 2017</h1>
		<h5>開催期間：2017年10月11日～2017年10月24日</h5>

		<div>
		<table>
		<tr><td colspan="1">Login</td></tr>
		<tr><td>ID</td><td><input type="text"></td></tr>
		<tr><td>パスワード</td><td><input type="password"></td></tr>
		<tr><td colspan="1"><input type="submit"></td></tr>
		</table>
		</div>


	</div>

	</div>


	<div class="row">
	<div class="col-sm-6 col-sm-offset-3">
	&copy; Copyright <?php echo date('Y');?> ぐるなび
	</div>
	</div>



<footer>
	<div class="footer">
		<ul class="footer-list">
			<li class="footer-item">&copy; Gurunavi, Inc.</li>
			<li class="footer-item">主催：ぐるなび　協力：●●●●</li>
		</ul>
	</div>
</footer>
</body>
</html>
