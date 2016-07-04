<?php
Media::css('catalog.print.css', 'catalog/css');
?>
<div id="show_company_box" class="box primary entry_show_box">
	<div class="content">
		
		<div class="entry_body" itemscope itemtype="http://schema.org/Organization">
			
			<h1 itemprop="name"><?php echo $company->company_name ?></h1>
			
			<div class="content">
				
				<div class="entry_row">
					<div class="entry_row_col">
					
						<?php 
						$images_limit = $company->get_promotion_type_limit('images'); 
						$images = $company->get_images();

						if($images_limit AND count($images)): ?>
						<div class="entry-content-box">
							<h3><?php echo ___('photos') ?>:</h3>
							<div class="slider-gallery">
								<div class="big-photo">
									<a class="photo_big" title="<?php echo Security::xss_clean($company->company_name) ?>" href="<?php echo $images->first()->get_url('catalog_company_big') ?>" >
										<img src="<?php echo $images->first()->get_url('catalog_company_thumb_big') ?>" alt="<?php echo HTML::chars($company->company_name) ?>" itemprop="image">
									</a>
								</div>
								<div class="nav">
									<div class="slider">
										<div class="items">
											<?php foreach(new LimitIterator($images, 0, $images_limit) as $image): ?>
											<a class="slide_photo" href="<?php echo $image->get_url('catalog_company_big') ?>" data-big_thumb="<?php echo $image->get_url('catalog_company_thumb_big') ?>">
												<img src="<?php echo $image->get_url('catalog_company_list') ?>" alt="<?php echo HTML::chars($company->company_name) ?>">
											</a>
											<?php endforeach ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php endif; ?>
					
					</div>
					<div class="entry_row_col">
				
						<?php $logo = $company->get_logo(); ?>
						<div class="entry_info <?php if($logo): ?> with-logo <?php endif ?>">

							<?php if($logo AND $logo->exists('catalog_company_list')): ?>
							<div class="company-logo">
								<img src="<?php echo $logo->get_url('catalog_company_list') ?>" alt="<?php echo HTML::chars($company->company_name) ?>" itemprop="logo" />
							</div>
							<?php endif; ?>

							<div itemprop="location" itemscope itemtype="http://schema.org/Place">
								<table class="top" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
									<?php if (catalog::config('map') AND $company->get_contact()->address->province): ?>
									<tr>
										<th><span><?php echo ___('province') ?>:</span></th>
										<td class="orange"><strong itemprop="addressRegion"><?php echo $company->get_contact()->address->province ?></strong></td>
									</tr>

									<?php if($company->get_contact()->address->county AND $company->get_contact()->address->province_id != Regions::ALL_PROVINCES): ?>
									<tr>
										<th><span><?php echo ___('county') ?>:</span></th>
										<td><?php echo $company->get_contact()->address->county ?></td>
									</tr>
									<?php endif; ?>
									<?php endif ?>

									<tr>
										<th>
											<span>
												<?php echo ___('catalog.company_name') ?>
											</span>
										</th>

										<td itemprop="name"><?php echo $company->company_name ?></td>
									</tr>

									<?php if ($company->get_contact()->address->street): ?>
									<tr>
										<th><span><?php echo ___('address') ?>:</span></th>
										<td itemprop="streetAddress"><?php echo $company->get_contact()->address->street ?></td>
									</tr>
									<?php endif ?>

									<?php if ($company->get_contact()->address->city): ?>
									<tr>
										<th><span><?php echo ___('city') ?>:</span></th>
										<td itemprop="addressLocality"><?php echo $company->get_contact()->address->city ?></td>
									</tr>
									<?php endif ?>

									<?php if ($company->get_contact()->address->postal_code): ?>
									<tr>
										<th><span><?php echo ___('postal_code') ?>:</span></th>
										<td itemprop="postalCode"><?php echo $company->get_contact()->address->postal_code ?></td>
									</tr>
									<?php endif ?>

									<?php if ($company->get_contact()->phone): ?>
									<tr>
										<th><span><?php echo ___('telephone') ?>:</span></th>
										<td><?php echo $company->get_contact()->phone ?></td>
									</tr>
									<?php endif ?>

									<?php if (!catalog::config('email_view_disabled') AND $company->get_contact()->email): ?>
									<tr>
										<th><span><?php echo ___('email') ?>:</span></th>
										<td><?php echo $company->get_contact()->email ?></td>
									</tr>
									<?php endif ?>

									<?php if ($company->get_contact()->www): ?>
									<tr>
										<th><span><?php echo ___('catalog.link') ?>:</span></th>
										<td><a href="<?php echo Tools::link($company->get_contact()->www) ?>" target="_blank"><?php echo URL::idna_decode($company->get_contact()->www) ?></a></td>
									</tr>
									<?php endif ?>

									<?php if ($company->get_contact()->nip): ?>
									<tr>
										<th><span><?php echo ___('nip') ?>:</span></th>
										<td><?php echo HTML::chars($company->get_contact()->nip) ?></td>
									</tr>
									<?php endif ?>

									<?php if ($company->has_company_hours()): ?>
									<tr>
										<th><span><?php echo ___('catalog.company_hours') ?>:</span></th>
										<td class="company_hours">
											<?php foreach($company->company_hours as $day => $hours): if(isset($hours['open']) AND $hours['open'] != Model_Catalog_Company::COMPANY_HOURS_NONE): ?>
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

									<tr>
										<th>&nbsp;</th>
										<th>&nbsp;</th>
									</tr>
									<tr>
										<th><span><?php echo ___('catalog.companies.show.date_added') ?>:</span></th>
										<td><?php echo date('Y.m.d', strtotime($company->company_date_added)) ?></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
				
				<div class="clearfix"></div>

				<div id="company-description">
					<div class="entry-content entry-content-box">
						<h3><?php echo ___('catalog.company_description') ?>:</h3>
						<div itemprop="description">
							<?php
								$content = $company->company_description;
								$content = Text::linkify($content);
								echo $content;
							?>
						</div>
					</div>
				</div>
				
			</div>

		</div>

	</div>
		
</div>