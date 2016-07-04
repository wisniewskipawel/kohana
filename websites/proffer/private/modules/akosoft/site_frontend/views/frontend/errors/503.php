<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		
		<title><?php echo ___('errors.503.title') ?></title>
		
		<style>
			body {
				text-align: center;
			}
		</style>
	</head>
	<body>
		<div class="header">
			<img src="<?php echo URL::site('/media/img/logo.png') ?>" alt="Logo" />
		</div>
		<p><?php echo Kohana::$config->load('global.site.disabled_text') ?></p>
	</body>
</html>
