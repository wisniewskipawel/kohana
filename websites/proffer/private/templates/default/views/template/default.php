<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">

		<?php if(isset($meta_tags))
			foreach($meta_tags as $m) 
				echo "<meta".HTML::attributes($m).">\n";
		?>
		
		<title><?php echo Security::escape_text($meta_title) ?></title>
		
		<?php if (isset($rss_links)) foreach($rss_links as $rss): ?>
		<link rel="alternate" type="application/rss+xml" title="<?php echo Arr::get($rss, 'title') ?>" href="<?php echo URL::site(Arr::get($rss, 'uri')) ?>" />
		<?php endforeach ?>
		
		<?php
		//assets
		Media::js('akoCarousel.js');
		Media::css('jquery.fancybox-1.3.4.css', 'js/libs/fancybox/', array('minify' => TRUE));
		Media::js('jquery.fancybox-1.3.4.js', 'js/libs/fancybox/');
		Media::js('jquery.tools.min.js');
		
		Media::css('custom.css', NULL, array('minify' => TRUE));
		
		echo Media::css() ?>
		
		<!--[if lt IE 9]>
			<?php echo HTML::script('media/js/html5.js') ?>
		<![endif]-->
		
		<?php 
		Media::js('scripts.js', NULL, array('minify' => TRUE));
		
		echo Media::js() 
		?>
	</head>
	<body>
		<?php echo View::factory('javascript_settings') ?>
		
		<div class="header-wrapper">
			<div class="wrapper">
				<header>

					<div id="logo">
						<a href="<?php echo URL::site('/') ?>">
							<img src="<?php echo URL::site('/media/img/logo.png') ?>" alt="Logo" />
						</a>
					</div>

					<div id="search_box">
						<?php echo Events::fire_once($action_tab, 'layout/header/search_box'); ?>
					</div>

					<div id="header_user_panel">
						<?php if(BAuth::instance()->is_logged()): ?>

						<div class="info">
							<?php echo ___('users.logged_as') ?> 
							<strong><?php echo $current_user->user_name ?></strong>
						</div>

						<ul id="logged_user_nav" class="user_nav">

							<li><?php 
							echo HTML::anchor(
								Route::get('site_profile/frontend/profile/index')->uri(),
								___('profile.title')
							); ?></li>

							<li><?php 
							echo HTML::anchor(
								Route::get('site_profile/profile/settings/change')->uri(),
								___('profile.settings')
							); ?></li>

							<?php if(Route::exists($action_tab.'/profile/closet')): ?>
							<li><?php 
							echo HTML::anchor(
								Route::get($action_tab.'/profile/closet')->uri(),
								___('profile.closet')
							); ?></li>
							<?php elseif(Route::exists(Site::current_home_module().'/profile/closet')): ?>
							<li><?php 
							echo HTML::anchor(
								Route::get(Site::current_home_module().'/profile/closet')->uri(),
								___('profile.closet')
							); ?></li>
							<?php endif; ?>
							
							<li>
								<?php 
								echo HTML::anchor(
									Route::get('bauth/frontend/auth/logout')->uri(),
									___('users.logout.btn')
								); ?>
							</li>
						</ul>

						<?php else: ?>

						<ul id="not_logged_user_nav" class="user_nav">
							<li>
								<?php 
								echo HTML::anchor(
									Route::get('bauth/frontend/auth/login')->uri(),
									___('users.login')
								); ?>
							</li>
							<li>
								<?php 
								echo HTML::anchor(
									Route::get('bauth/frontend/auth/register')->uri(),
									___('users.register')
								); ?>
							</li>
						</ul>

						<?php if(Kohana::$config->load('modules.bauth.facebook.enabled')) 
							echo View::factory('auth/facebook/login_button') ?>

						<?php endif; ?>
					</div>

					<?php if($current_request->uri() == '/' AND $home_text = Kohana::$config->load('global.layout.home_header_text')): ?>
					<h1><?php echo $home_text ?></h1>
					<?php endif; ?>

				</header>

				<div class="top_bar">
					<nav id="modules_nav">
						<ul class="top_bar_nav">
							<?php 
							$modules_nav_event = Events::fire('frontend/modules_nav', NULL, TRUE); 
							$active_module_nav = NULL;
							
							if(!empty($modules_nav_event)) foreach($modules_nav_event as $module_nav): 
								if(isset($module_nav['active']) AND $module_nav['active'])
								{
									$active_module_nav = $module_nav;
								}
							?>
							<li class="<?php if (isset($module_nav['active']) AND $module_nav['active']): ?>active<?php endif ?>">
								<?php echo HTML::anchor($module_nav['url'], $module_nav['title']); ?>
							</li>
							<?php endforeach; ?>
						</ul>
					</nav>
					<?php if($active_module_nav AND !empty($active_module_nav['subnav'])): ?>
					<nav id="modules_subnav">
						<ul class="top_bar_subnav">
							<?php foreach($active_module_nav['subnav'] as $module_subnav): ?>
							<li class="<?php if (isset($module_subnav['active']) AND $module_subnav['active']): ?>active<?php endif ?>">
								<?php echo HTML::anchor($module_subnav['url'], $module_subnav['title']); ?>
							</li>
							<?php endforeach; ?>
						</ul>
					</nav>
					<?php endif; ?>
				</div><!-- /.top_bar -->

				<?php if(isset($module_bar)) echo $module_bar; ?>

				<div class="main_top">

					<?php if(breadcrumbs::not_empty()): ?>
					<div id="breadcrumbs">
						<span><?php echo ___('breadcrumbs.here') ?>:</span>
						<?php breadcrumbs::render('site') ?>
					</div>
					<?php endif; ?>

					<div class="pull-right">

						<?php if($top_counter = Events::fire_once($action_tab, 'layout/header/top_counter')): ?>
						<div class="stats">
							<?php echo $top_counter; ?>
						</div>
						<?php endif; ?>

						<?php echo Events::fire_once($action_tab, 'layout/header/add_button'); ?>
					</div>
				</div><!-- /.main_top -->
				
			</div><!-- /.wrapper -->
		</div><!-- /.header-wrapper -->
		
		<div class="wrapper">
			<div id="main">
				
				<?php  echo isset($layout) ? $layout : ''; ?>
			
			</div>
		</div>
			
		<div class="page_bottom">
			<?php echo Events::fire('frontend/footer') ?>
		</div>
		
		<div id="footer-wrapper">
			<nav>
				<?php echo Events::fire('frontend/documents/footer') ?>
			</nav>
			<p>
				&copy; Copyright 
				<?php 
				if($copyright_text = Kohana::$config->load('global.layout.copyright_text')) 
				{
					echo $copyright_text;
				}
				else 
				{
					echo '2008-'.date('Y').' AkoPortal';
				}
				?>
				<br />
				<?php echo ___('realization') ?>: <a href="http://www.akosoft.pl" target="_blank"><strong>AkoSoft</strong></a>
			</p>
		</div>
		
		<div class="clearfix"></div>
		
		<?php if(Kohana::$config->load('global.layout.cookie_alert.enabled') AND empty($_COOKIE['cookie_law'])): ?>
		<!-- Cookie alert -->
		<div class="cookie-alert">
		   <div class="wrapper">
			   <p class="text">
			   <?php echo Kohana::$config->load('global.layout.cookie_alert.text') ?>
			  </p>
			  <a class="close" href="#"><?php echo ___('close') ?></a>
		   </div>
		   <script type="text/javascript">
		   $(function() {
			   $('.cookie-alert .close').bind('click', function (e) {
				   e.preventDefault();

				   var date = new Date();
				   date.setDate(date.getDate() + 365);

				   document.cookie = "cookie_law=1;path=<?php echo Cookie::$path ?>;expires=" + date.toUTCString();
				   $('.cookie-alert').remove();
			   })
		   });
		   </script>
		</div>
		<?php endif; ?>
		
		<?php if($google_analytics_account = Kohana::$config->load('global.layout.google_analytics_account')): ?>
		<script>
		var _gaq=[['_setAccount','<?php echo $google_analytics_account ?>'],['_trackPageview']];
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
		g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g,s)}(document,'script'));
		</script>
		<?php endif; ?>
		
		<?php echo Events::fire('layout/bottom') ?>
	</body>
</html>

