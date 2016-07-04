<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		
		<title><?php if(isset($title)) echo $title.' - '; ?>AkoSoft - <?php echo ___('admin.title') ?></title>
		
		<?php echo HTML::style('media/css/reset.css') ?>
		<?php echo HTML::style('media/css/main.admin.css') ?>
		<?php echo HTML::style('media/css/redmond/jquery-ui-1.8.13.custom.css') ?>
		<?php echo HTML::style('media/css/uploadify.css') ?>
		<?php echo HTML::style('media/css/jquery-ui-timepicker-addon.css') ?>
		<?php echo HTML::script('media/js/jquery-1.7.1.min.js') ?>
		<?php echo HTML::script('media/js/jquery-ui-1.8.13.custom.min.js') ?>
		<?php echo HTML::script('media/js/jquery.tablesorter.min.js') ?>
		<?php echo HTML::script('media/js/jquery.cookie.js') ?>
		<?php echo HTML::script('media/js/jquery.uploadify.v2.1.4.js') ?>
		<?php echo HTML::script('media/js/swfobject.js') ?>
		<?php echo HTML::script('media/js/jquery-ui-timepicker-addon.js') ?>
		<?php echo HTML::script('media/js/scripts.admin.js') ?>
	</head>
	<body id="adsystem">
	
		<script type="text/javascript">
			base_url = '<?php echo URL::site('/', 'http') ?>';
		</script>

		<div id="header">
			<div id="header-wrapper">
				<a href="<?php echo URL::site('/adsystem') ?>">
					<img src="<?php echo URL::site('/media/img/admin/logo.png') ?>" alt="AkoSoft"  id="logo" />
				</a>

				<div id="header-logout">
					<p><?php echo ___('users.logged_as')?>: <span class="underline"><?php echo $user_name ?></span></p>
					<div id="button"><a href="<?php echo URL::site('/adsystem/auth/logout') ?>" class="logout_btn" ><?php echo ___('users.logout.btn') ?></a></div>
				</div>

				<div id="go-to-main" >
					<p>
						<?php echo ___('admin.goto')?> 
						<a target="_blank" href="<?php echo URL::site('/') ?>"><span class="bold"><?php echo ___('admin.goto.btn') ?></span></a>
					</p>
				</div>

				<h1><span class="bold"><?php echo ___('admin.title') ?></span> - AkoPortal</h1>
				<div id="breadcrumbs"><img src="<?php echo URL::site('/media/img/admin/info_icon.png') ?>" alt="" style="width:12px; height:12px;" />
					<p><span class="bold"><?php echo ___('breadcrumbs.here') ?></span>: <?php breadcrumbs::render('admin') ?></p>
				</div>
			</div>
		</div>

		<div id="wrapper">
			<div id="sidebar">
				<?php echo View::factory('adsystem/menu') ?>
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