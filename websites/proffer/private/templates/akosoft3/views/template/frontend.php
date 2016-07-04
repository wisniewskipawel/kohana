<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		
        <title><?php echo Security::escape_text($meta_title) ?></title>
			
		<?php if(isset($meta_tags))
			foreach($meta_tags as $m) 
				echo "<meta".HTML::attributes($m).">\n";
		?>
		
		<?php if (isset($rss_links)) foreach($rss_links as $rss): ?>
		<link rel="alternate" type="application/rss+xml" title="<?php echo Arr::get($rss, 'title') ?>" href="<?php echo URL::site(Arr::get($rss, 'uri')) ?>" />
		<?php endforeach ?>

	    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,700,700italic|Roboto:400,300,300italic,400italic,700,700italic|Roboto+Condensed:400,300,300italic,400italic,700,700italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

		<?php
		//assets
		Media::css('jquery.fancybox-1.3.4.css', 'js/vendor/fancybox/', array('minify' => TRUE));
		Media::js('jquery.fancybox-1.3.4.js', 'js/vendor/fancybox/');
		Media::js('jquery.tools.min.js');
		
		Media::css('custom.css', NULL, array('minify' => TRUE));
		
		echo Media::css() ?>
		
		<?php 
		Media::js('scripts.js', NULL, array('minify' => TRUE));
		
		echo Media::js() 
		?>
    </head>
    <body>
		<?php echo View::factory('javascript_settings') ?>
		
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
		
		<div class="header_top">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<?php if($imieniny = (array)Kohana::$config->load('imieniny')): ?>
						<div class="today_info">
							<?php
							echo ___('posts.layout.header_top_counter', array(
								':date' => '<strong>'.date('j.n.Y').'</strong>',
								':fete' => '<strong>'.Arr::path($imieniny, date('n.j')).'</strong>',
							));
							?>
						</div>
						<?php endif; ?>
					</div>
					<div class="col-sm-6">
						<?php if(!BAuth::instance()->is_logged()): ?>
						<?php if(Kohana::$config->load('modules.bauth.facebook.enabled')): ?>
							<?php echo HTML::anchor(
								Route::get('bauth/frontend/facebook/login')->uri(), 
								___('users.facebook.login.btn'), 
								array('class' => 'login_facebook_btn')
							) ?>
						<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		
		<header class="navbar navbar-default" role="navigation">
			<div class="container">
				
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#user_nav">
						<span class="glyphicon glyphicon-user"></span>
					</button>
				
					<div id="logo">
						<a href="<?php echo Route::url('index') ?>">
							<img src="<?php echo URL::site('/media/img/logo.png') ?>" alt="Logo" />
						</a>
					</div>
				</div>
				
				<div class=" navbar-right">
					<div id="user_nav" class="navbar-collapse collapse">
						<?php if(BAuth::instance()->is_logged()): ?>
						<div class="info navbar-text">
							<?php echo ___('users.logged_as') ?> <strong><?php echo $current_user->user_name ?></strong>
						</div>

						<ul id="header_user_nav">

							<li><?php 
							echo HTML::anchor(
								Route::get('site_profile/frontend/profile/index')->uri(),
								___('profile.title')
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
							<li class="logout">
								<?php 
								echo HTML::anchor(
									Route::get('bauth/frontend/auth/logout')->uri(),
									___('users.logout.btn')
								); ?>
							</li>
						</ul>
						<?php else: ?>
						<div id="not_logged_user_nav">
							<?php 
							echo HTML::anchor(
								Route::get('bauth/frontend/auth/login')->uri(),
								___('users.login'),
								array(
									'class' => 'login_btn',
								)
							); 
							?>
							<?php 
							echo HTML::anchor(
								Route::get('bauth/frontend/auth/register')->uri(),
								___('users.register'),
								array(
									'class' => 'register_btn',
								)
							); 
							?>
						</div>
						<?php endif; ?>
					</div><!--/.navbar-collapse -->
				
					<?php echo Events::fire_once($action_tab, 'layout/header/add_button'); ?>
				</div>
			
			</div>
				
			<?php if($current_request->uri() == '/' AND $home_text = Kohana::$config->load('global.layout.home_header_text')): ?>
			<div class="container">
				<h1><?php echo $home_text ?></h1>
			</div>
			<?php endif; ?>
			
		</header>
		
		<div id="modules_nav_side">
			<div class="container">

				<?php 
				$modules_nav_event = Events::fire('frontend/modules_nav', NULL, TRUE); 

				if(!empty($modules_nav_event)):
					$active_module_nav = NULL;

					foreach($modules_nav_event as $module_nav)
						if(isset($module_nav['active']) AND $module_nav['active'])
						{
							$active_module_nav = $module_nav;
						}
				?>
				
				<button type="button" class="btn btn-block change-module-btn" data-toggle="collapse" data-target="#modules_nav">
					<?php echo $active_module_nav['title'] ?>
					<span class="caret"></span>
				</button>
				
				<nav id="modules_nav" class="collapse">
					<ul class="nav nav-pills">
						<?php foreach($modules_nav_event as $module_nav): ?>
						<li class="<?php if (isset($module_nav['active']) AND $module_nav['active']): ?>active<?php endif ?>">
							<?php echo HTML::anchor($module_nav['url'], $module_nav['title']); ?>
						</li>
						<?php endforeach; ?>
					</ul>
				</nav>
				
				<?php endif; ?>
				
			</div>
		</div><!-- /#modules_nav_side -->
				
		<?php if(!empty($active_module_nav['subnav'])): ?>
		<div id="modules_subnav_side">
			<div class="container">
				<nav id="modules_subnav">
					<ul class="top_bar_subnav nav nav-pills">
						<?php foreach($active_module_nav['subnav'] as $module_subnav): ?>
						<li class="<?php if (isset($module_subnav['active']) AND $module_subnav['active']): ?>active<?php endif ?>">
							<?php echo HTML::anchor($module_subnav['url'], $module_subnav['title']); ?>
						</li>
						<?php endforeach; ?>
					</ul>
				</nav>
			</div>
		</div><!-- /#modules_subnav_side -->
		<?php endif; ?>
		
		<?php if(isset($module_nav_side)): ?>
		
		<div id="module_nav_side">
			<div class="container">
				<?php echo $module_nav_side ?>
			</div>
		</div><!-- /#module_nav_side -->
		
		<?php else: ?>
		
		<?php if($search_box = Events::fire_once($action_tab, 'layout/header/search_box')): ?>
		<div id="module_heading">
			<div class="container">

				<div>
					<?php if($top_counter = Events::fire_once($action_tab, 'layout/header/top_counter')): ?>
					<div class="stats">
						<?php echo $top_counter; ?>
					</div>
					<?php endif; ?>
					
					<div id="search_box">
						<?php echo $search_box; ?>
					</div>
				</div>
				
			</div>
		</div><!-- /#module_heading -->
		<?php endif; ?>
		
		<?php endif; ?>
		
		<?php if(breadcrumbs::not_empty()): ?>
		<div class="main_top">
			<div class="container">

				<div id="breadcrumbs">
					<span><?php echo ___('breadcrumbs.here') ?>:</span>
					<?php breadcrumbs::render('site') ?>
				</div>
				
			</div>
		</div><!-- /.main_top -->
		<?php endif; ?>
		
		<?php if(Modules::enabled('site_ads')) echo ads::show(ads::PLACE_A) ?>
		
		<?php if(isset($section_pre_main)): ?>
		<div class="pre_main">
			<div class="container">
				<?php echo $section_pre_main ?>
			</div>
		</div>
		<?php endif; ?>
		
		<div id="main">
			<div class="container skycraper_container">
				<?php  echo isset($layout) ? $layout : ''; ?>
			</div>
		</div>
		
		<?php if(Modules::enabled('site_ads')): ?>
		<?php
		$ads = Model_Ad::factory()->get_by_type_many(Model_Ad::TEXT_C1, 7);

		echo View::factory('component/ads/footer')
			->set('ads', $ads);
		?>
		<?php endif; ?>
		
		<?php if($template->config('modules_box_enabled')): ?>
		<?php echo Widget_Box::factory('modules')->render(); ?>
		<?php endif; ?>
		
		<?php if(Modules::enabled('site_newsletter') AND $template->config('site_newsletter.index_box_enabled')): ?>
		<?php echo Widget_Box::factory('newsletter')->render('widget/newsletter_bottom') ?>
		<?php endif; ?>
		
        <footer>
			<div class="container">
                <div class="row">
					<div class="col-md-9">
						<?php echo Events::fire('frontend/documents/footer') ?>
					</div>
					
					<div class="col-md-3">
						<div class="copyrights">
							&copy; Copyright 
							<?php 
							if($copyright_text = Kohana::$config->load('global.layout.copyright_text')) 
								echo $copyright_text;
							else 
								echo '2008-'.date('Y').' AkoPortal';
							?>
							<div class="realization">
								<?php echo ___('realization') ?>: <a href="http://www.akosoft.pl" target="_blank"><strong>AkoSoft</strong></a>
							</div>
						</div>
					</div>
				</div>
			</div>
        </footer>
		
		<?php echo Widget_Box::factory('overlay')->render() ?>

		<?php if(Kohana::$config->load('global.layout.hot_info_slider.enabled')):
			$hot_info = Kohana::$config->load('global.layout.hot_info_slider');
			?>
			<a href="<?php echo Tools::link($hot_info['url']) ?>" target="_blank" class="hot-info-slider" title="<?php echo HTML::chars(strip_tags($hot_info['text'])) ?>" style="<?php if($hot_info['color']) echo 'color: '.$hot_info['color'].';'; if($hot_info['background']) echo 'background: '.$hot_info['background'].';'; ?>">
				<div class="inner">
					<?php echo $hot_info['text'] ?>
				</div>
			</a>
		<?php endif; ?>
		
		<?php if(Kohana::$config->load('global.layout.cookie_alert.enabled') AND empty($_COOKIE['cookie_law'])): ?>
		<!-- Cookie alert -->
		<div class="cookie-alert">
		   <div class="wrapper">
			   <p class="text">
			   <?php echo Kohana::$config->load('global.layout.cookie_alert.text') ?>
			  </p>
			  <a class="close-alert-btn" href="#"><?php echo ___('close') ?></a>
		   </div>
		   <script type="text/javascript">
		   $(function() {
			   $('.cookie-alert .close-alert-btn').bind('click', function (e) {
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
		
    </body>
</html>
