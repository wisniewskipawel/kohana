<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		
		<title><?php echo ___('install.title') ?></title>
		
		<?php echo HTML::style('media/css/reset.css') ?>
		<?php echo HTML::style('media/css/main.admin.css') ?>
		<?php echo HTML::script('media/js/scripts.admin.js') ?>
	</head>
	<body>

		<div id="header">
			<div id="header-wrapper">
				<a href="<?php echo URL::site('/admin') ?>">
					<img src="<?php echo URL::site('/media/img/admin/logo.png') ?>" alt="AkoSoft"  id="logo" />
				</a>

				<h1><span class="bold"><?php echo ___('install.title') ?></span></h1>
			</div>
		</div>
		
		<div id="wrapper">
		
			<div id="sidebar">
				&nbsp;
			</div>
			
			<div id="main">
				<?php echo FlashInfo::render() ?>
				<?php echo @$content ?>
			</div>
			
		</div>
		
		<div id="footer">
			&copy; <?php echo date('Y') ?> <a href="http://www.akosoft.pl">AkoSoft</a> <?php echo ___('all_rights_reserved') ?>
		</div>
	</body>
</html>