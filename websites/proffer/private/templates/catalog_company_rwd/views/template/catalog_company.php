<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">

		<?php if(isset($meta_tags))
			foreach($meta_tags as $m) 
				echo "<meta".HTML::attributes($m).">\n";
		?>
		
		<title><?php echo Security::escape_text(isset($meta_title) && !empty($meta_title) ? $meta_title : Kohana::$config->load('global.site.meta.title')) ?></title>
		
		<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		
		<?php
		//assets
		Media::css('common.css');
		Media::css('main.css', 'catalog_company_rwd/css/');
		
		Media::css('jquery.fancybox-1.3.4.css', 'js/libs/fancybox/');
		Media::js('jquery.fancybox-1.3.4.js', 'js/libs/fancybox/');
		
		Media::js('jquery.tools.min.js');
		
		echo Media::css(); ?>
		
		<?php echo HTML::script('media/js/libs/jquery.min.js') ?>
		<?php echo HTML::script('media/js/jquery.custom-select.js') ?>
		<?php echo HTML::script('media/js/jquery.tools.min.js') ?>
		
		<?php if(!empty($styles)) foreach($styles as $style) echo HTML::style($style) ?>
		
		<!--[if lt IE 9]>
			<?php echo HTML::script('media/js/html5.js') ?>
		<![endif]-->
		
		<?php echo HTML::script('media/catalog_company_rwd/js/main.js') ?>
		<?php echo Media::js() ?>
	</head>
	<body id="layout_company" itemscope itemtype="http://schema.org/Organization">
		<?php echo View::factory('javascript_settings') ?>
		
		
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
		
		<header>
			<div class="container">
				
				<div id="logo">
					<a href="<?php echo catalog::url($current_company) ?>">
						<?php $logo = $current_company->get_logo(); if($logo && $logo->exists('catalog_company_list')): ?>
						<img src="<?php echo $logo->get_url('catalog_company_list') ?>" alt="" itemprop="logo" />
						<?php else: ?>
						<img src="<?php echo URL::site('/media/img/logo.png') ?>" alt="Logo" />
						<?php endif ?>
					</a>
				</div>
				
				<h1 itemprop="name"><?php echo HTML::chars($current_company->company_name) ?></h1>
				
			</div>
		</header>
		
		<div id="menu_nav_side">
			<div class="container">

				<?php 
				$main_menu = $template->get_main_menu();

				$active_nav = NULL;

				foreach($main_menu as $li)
					if(isset($li['active']) AND $li['active'])
					{
						$active_nav = $li;
					}
				?>
				
				<button type="button" class="btn btn-block menu_nav-btn" data-toggle="collapse" data-target="#menu_nav">
					<?php echo $active_nav['title'] ?>
					<span class="caret"></span>
				</button>
				
				<nav id="menu_nav" class="collapse">
					<ul class="nav nav-pills">
						<?php foreach($main_menu as $list_item_name => $list_item): ?>
						<li class="<?php echo $list_item_name ?><?php if ($list_item['active']): ?> active<?php endif ?>">
							<a href="<?php echo $list_item['url'] ?>"><?php echo $list_item['title'] ?></a>
						</li>
						<?php endforeach; ?>
					</ul>
				</nav>
				
			</div>
		</div><!-- /#modules_nav_side -->
		
		<div id="main">
			<div class="container">
				
				<div id="content" class="col-md-8 col-md-push-4">
					
					<div id="flashinfo">
						<?php echo FlashInfo::render() ?>
					</div>
					
					<?php echo @$content ?>
					
				</div>
				<div id="sidebar" class="col-md-4 col-md-pull-8">
				
					<div id="contact_details-box" class="box"> 
						<h2 class="box-header"><?php echo ___('catalog.subdomain.contact_data.title') ?></h2>
						<div class="box-content">
							
							<div class="address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
								<?php echo $current_company->get_contact()->address->render('single_line') ?>
							</div>
							
							<?php if ($current_company->get_contact()->nip): ?>
							<div class="company_nip">
								<span><?php echo ___('nip') ?>:</span>
								<span class="val"><?php echo HTML::chars($current_company->get_contact()->nip) ?></span>
							</div>
							<?php endif ?>
							
							<div class="contact-meta">
								<?php if ( !catalog::config('email_view_disabled') && $current_company->get_contact()->email): ?>
								<div class="email" title="<?php echo ___('email') ?>">
									<?php echo catalog::curtain($current_company, 'email', ___('email.curtain')) ?>
								</div>
								<?php endif ?>

								<?php if ($current_company->get_contact()->phone): ?>
								<div class="phone" title="<?php echo ___('telephone') ?>">
									<?php echo catalog::curtain($current_company, 'telephone', ___('telephone.curtain')) ?>
								</div>
								<?php endif ?>

								<?php if($current_company->get_contact()->www): ?>
								<div class="www" title="<?php echo ___('www') ?>">
									<a href="<?php echo Tools::link($current_company->get_contact()->www) ?>" target="_blank"><?php echo URL::idna_decode($current_company->get_contact()->www) ?></a>
								</div>
								<?php endif ?>
							</div>
							
						</div>
					</div>
					
					<?php if($current_company->get_contact()->address->province_id != Regions::ALL_PROVINCES): ?>
					<?php echo View::factory('frontend/catalog/partials/map')->set('company', $current_company) ?>
					<?php endif; ?>
					
					<?php if ($current_company->has_company_hours()): ?>
					<div id="opening_hours-box" class="box">
						<h2 class="box-header"><?php echo ___('catalog.company_hours') ?>:</h2>
						<div class="box-content">
							<div class="company_hours">
								<?php foreach($current_company->company_hours as $day => $hours): if(isset($hours['open']) AND $hours['open'] != Model_Catalog_Company::COMPANY_HOURS_NONE): ?>
								<div class="days">
									<span><?php echo ___('date.days.abbr.'.$day) ?>. :</span>
									<?php if($hours['open'] == Model_Catalog_Company::COMPANY_HOURS_OPEN): ?>
									<?php echo $hours['from'].' - '.$hours['to'] ?>
									<?php elseif($hours['open'] == Model_Catalog_Company::COMPANY_HOURS_CLOSED): 
										$hours = (array)$hours; ?>
									<?php echo ___('catalog.forms.company_hours.open.0') ?>
									<?php endif; ?>
								</div>
								<?php endif; endforeach; ?>
							</div>
						</div>
					</div>
					<?php endif; ?>
					
				</div><!-- /#sidebar -->
				
			</div>
		</div>
		
        <footer>
			<div class="container">
                <div class="row">
					<div class="col-md-9">
						<div class="copyrights">
							&copy; Copyright 
							<?php 
							if($copyright_text = Kohana::$config->load('global.layout.copyright_text')) 
								echo $copyright_text;
							else 
								echo '2008-'.date('Y').' AkoPortal';
							?>
						</div>
					</div>
					
					<div class="col-md-3">
						<div class="realization">
							<?php echo ___('realization') ?>: <a href="http://www.akosoft.pl" target="_blank"><strong>AkoSoft</strong></a>
						</div>
					</div>
				</div>
			</div>
        </footer>
	</body>
</html>
