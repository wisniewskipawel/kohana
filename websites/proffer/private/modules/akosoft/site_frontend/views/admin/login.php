<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		
		<?php echo HTML::style('media/css/main.admin.css') ?>
		
		<title>AkoSoft | <?php echo ___('admin.title') ?></title>
	</head>
	<body>
		<div id="login-wrapper">
			<h1><?php echo ___('admin.login') ?></h1>
			
			<?php echo FlashInfo::render() ?>
			
			<?php echo @$content ?>
		</div>
	</body>
</html>