<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">

		<?php if(isset($meta_tags))
			foreach($meta_tags as $m) 
				echo "<meta".HTML::attributes($m).">\n";
		?>
		
		<title><?php echo Security::escape_text(isset($meta_title) && !empty($meta_title) ? $meta_title : Kohana::$config->load('global.site.meta.title')) ?></title>
		
		<?php
		//assets
		Media::css('reset.css');
		Media::css('common.css');
		Media::css('main.css', 'catalog_company_default/css/');
		
		Media::css('jquery.fancybox-1.3.4.css', 'js/libs/fancybox/');
		Media::js('jquery.fancybox-1.3.4.js', 'js/libs/fancybox/');
		
		Media::js('jquery.tools.min.js');
		
		Media::js('scripts.js', NULL, array('minify' => TRUE));
		
		echo Media::css(); ?>
		
		<?php echo HTML::script('media/js/libs/jquery.min.js') ?>
		<?php echo HTML::script('media/js/jquery.custom-select.js') ?>
		<?php echo HTML::script('media/js/jquery.tools.min.js') ?>
		
		<?php if(!empty($styles)) foreach($styles as $style) echo HTML::style($style) ?>
		
		<!--[if lt IE 9]>
			<?php echo HTML::script('media/js/html5.js') ?>
		<![endif]-->
		
		<?php echo HTML::script('media/catalog_company_default/js/main.js') ?>
		<?php echo Media::js() ?>
	</head>
	<body id="layout_company">
		<?php echo View::factory('javascript_settings') ?>
		<div class="wrapper">
			<header>
				
				<div id="logo">
					<a href="<?php echo catalog::url($current_company) ?>">
						<?php $logo = $current_company->get_logo(); if($logo && $logo->exists('catalog_company_list')): ?>
						<img src="<?php echo $logo->get_url('catalog_company_list') ?>" alt="" />
						<?php else: ?>
						<img src="<?php echo URL::site('/media/img/logo.png') ?>" alt="Logo" />
						<?php endif ?>
					</a>
				</div>
				
				<ul id="header-tabs">
					<li>
						<a class="<?php if ($action_tab == 'about'): ?>active<?php endif ?>" href="<?php echo catalog::url($current_company, 'show') ?>"><?php echo ___('catalog.subdomain.about.title') ?></a>
					</li>
					<li>
						<a class="<?php if ($action_tab == 'gallery'): ?>active<?php endif ?>" href="<?php echo catalog::url($current_company, 'gallery') ?>"><?php echo ___('catalog.subdomain.gallery.title') ?></a>
					</li>
					<li>
						<a class="<?php if ($action_tab == 'contact'): ?>active<?php endif ?>" href="<?php echo catalog::url($current_company, 'contact') ?>"><?php echo ___('catalog.subdomain.contact.title') ?></a>
					</li>
					<?php if(Kohana::$config->load('modules.site_catalog.settings.reviews.enabled')): ?>
					<li>
						<a class="<?php if ($action_tab == 'reviews'): ?>active<?php endif ?>" href="<?php echo catalog::url($current_company, 'reviews') ?>"><?php echo ___('catalog.subdomain.reviews.title') ?></a>
					</li>
					<?php endif; ?>
					<?php foreach(Events::fire('catalog/show_company/pages', NULL, TRUE) as $tab): ?>
					<li>
						<a class="<?php if ($action_tab == $tab['page']): ?>active<?php endif ?>" href="<?php echo catalog::url($current_company, $tab['page']) ?>"><?php echo $tab['title'] ?></a>
					</li>
					<?php endforeach; ?>
				</ul>
				
			</header>
			
			<div id="main">
				<h1><?php echo HTML::chars($current_company->company_name) ?></h1>
				
				<div id="sidebar">
					
					<div id="contact_data_box" class="box gray">
						<h2><?php echo ___('catalog.subdomain.contact_data.title') ?></h2>
						<div class="content">
							
							<table>
								
								<?php if ($current_company->get_contact()->nip): ?>
								<tr>
									<th><?php echo ___('nip') ?>:</th>
									<td><?php echo HTML::chars($current_company->get_contact()->nip) ?></td>
								</tr>
								<?php endif ?>
								
								<?php if ($current_company->get_contact()->address->street): ?>
								<tr class="company_address">
									<th><?php echo ___('address') ?>:</th>
									<td><?php echo $current_company->get_contact()->address->street ?></td>
								</tr>
								<?php endif ?>
								
								<?php if ($current_company->get_contact()->address->city): ?>
								<tr class="company_city">
									<th><?php echo ___('city') ?>:</th>
									<td><?php echo $current_company->get_contact()->address->city ?></td>
								</tr>
								<?php endif ?>
								
								<?php if ($current_company->get_contact()->address->postal_code): ?>
								<tr class="company_postal_code">
									<th><?php echo ___('postal_code') ?>:</th>
									<td><?php echo $current_company->get_contact()->address->postal_code ?></td>
								</tr>
								<?php endif ?>
								
								<?php if (Kohana::$config->load('modules.site_catalog.map') AND $current_company->get_contact()->address->province): ?>
								<tr class="company_province">
									<th><?php echo ___('province') ?>:</th>
									<td><?php echo $current_company->get_contact()->address->province ?><td>
								</tr>
								
								<?php if(!empty($current_company->get_contact()->address->county) AND $current_company->get_contact()->address->province_id != Regions::ALL_PROVINCES): ?>
								<tr class="company_county">
									<th><?php echo ___('county') ?>:</th>
									<td><?php echo $current_company->get_contact()->address->county ?><td>
								</tr>
								<?php endif ?>
								
								<?php endif ?>
								
								<?php if ($current_company->get_contact()->phone): ?>
								<tr class="company_telephone">
									<th><?php echo ___('telephone') ?>:</th>
									<td><?php echo catalog::curtain($current_company, 'telephone', ___('telephone.curtain')) ?></td>
								</tr>
								<?php endif ?>
								
								<?php if (!catalog::config('email_view_disabled') AND $current_company->get_contact()->email): ?>
								<tr class="company_email">
									<th><?php echo ___('email') ?>:</th>
									<td><?php echo catalog::curtain($current_company, 'email', ___('email.curtain')) ?></td>
								</tr>
								<?php endif ?>
								
								<?php if ($current_company->get_contact()->www): ?>
								<tr>
									<th><?php echo ___('catalog.link') ?>:</th>
									<td><a href="<?php echo Tools::link($current_company->get_contact()->www) ?>" target="_blank"><?php echo URL::idna_decode($current_company->get_contact()->www) ?></a></td>
								</tr>
								<?php endif ?>
								
								<?php if ($current_company->has_company_hours()): ?>
								<tr>
									<th><?php echo ___('catalog.company_hours') ?>:</th>
									<td class="company_hours">
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
									</td>
								</tr>
								<?php endif ?>
								
							</table>
							
							<?php if($current_company->get_contact()->address->province_id != Regions::ALL_PROVINCES): ?>
							<?php echo View::factory('frontend/catalog/partials/map')->set('company', $current_company) ?>
							<?php endif; ?>
						</div>
					</div>
					
				</div>
				
				<div id="content">
					
					<div id="flashinfo">
						<?php echo FlashInfo::render() ?>
					</div>
					
					<?php echo @$content ?>
					
				</div>
			   
				<div class="clearfix"></div>
			</div>
			
		</div>
		
		<div id="footer" class="wrapper">
			<span>
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
				?> | 
				<?php echo ___('realization') ?>: <a href="http://www.akosoft.pl" target="_blank"><strong>AkoSoft</strong></a>
			</span>
		</div>
		
		<div class="clearfix"></div>
	</body>
</html>
