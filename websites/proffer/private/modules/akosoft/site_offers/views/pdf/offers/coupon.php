<table width="100%" height="78px" style="font-family: sans-serif; border-collapse:collapse; text-align: center; color: #5C5C5C; margin-bottom: 20px;">
	<tr>
		<td style="background: #EBEBEB; background-image: url('<?php echo URL::site('media/offers/img/coupon/title.png') ?>'); background-repeat: no-repeat; text-align: left; width: 240px; height: 76px; text-align: center; padding-right: 30px; font-size: 22px; color: white;">
			<?php echo ___('offers.show.discount_coupon') ?>
		</td>

		<td style="background: #EBEBEB; border-right: 1px solid #898989;">
			<div style="font-size: 12px;"><?php echo ___('offers.show.new_price.label') ?></div>
			<div style="color: #F26522; font-size: 20px; display: block; float: none; line-height: 24px; font-weight: bold;"><?php echo payment::price_format($offer->get_price_new()) ?></div>
			<div style="font-style: italic;font-size: 11px;">(<?php echo ___('offers.show.new_price.annotation', array(':price' => payment::price_format($offer->get_price_old() - $offer->get_price_new(), FALSE)))?>)</div>
		</td>

		<td style="border-right: 1px solid #898989;">
			<div style="font-size: 11px;"><?php echo ___('offers.show.old_price') ?></div>
			<div style="font-size: 12px; font-weight: bold;"><?php echo payment::price_format($offer->get_price_old()) ?></div>
		</td>

		<td>
			<div style="font-size: 13px;">
				<?php echo ___('offers.show.discount') ?>
				<span style="font-size: 14px; font-weight: bold; color: #0072BC;"><?php echo $offer->get_discount() ?>%</span>
			</div>
		</td>
	</tr>
</table>

<table width="100%" style="font-family: sans-serif; border-collapse:collapse;">
	<tr>
		<td style="text-align: center;">
			<img width="300" src="var:image_coupon" alt="" />
		</td>

		<td>
			<table style="font-size:11px; padding-left: 10px;">
				<tr>
					<td style="color: #01619F; font-size: 14px; font-weight: bold; border-bottom: 1px solid #898989;">
						<?php echo HTML::chars($offer->offer_title) ?>
					</td>
				</tr>
				<tr>
					<td style="font-size:13px; padding-top: 20px;">
						<div style=" color: #5C5C5C;">
							<div class="company_box sidebar_box">
								<label>
								<?php if ($offer->contact_data() instanceof Contact_Person): ?>
									<?php echo ___('offers.show.offer_person_type.person') ?>:
								<?php elseif ($offer->contact_data() instanceof Contact_Company): ?>
									<?php echo ___('offers.show.offer_person_type.company') ?>:
								<?php endif ?>
								</label>
								<br/>
								<div class="address">

									<h2 style="color: #01619F;"><?php echo $offer->contact_data()->display_name() ?></h2>

									<div>
										<?php if ($offer->contact_data()->address->postal_code): ?>
										<span class="postal_code"><?php echo $offer->contact_data()->address->postal_code ?></span>
										<?php endif ?>

										<?php if ($offer->contact_data()->address->city): ?>
										<span class="city"><?php echo $offer->contact_data()->address->city ?></span>
										<?php endif ?>
									</div>

									<?php if ($offer->contact_data()->address->street): ?>
									<div class="street"><?php echo $offer->contact_data()->address->street ?></div>
									<?php endif ?>

									<?php if (Kohana::$config->load('modules.site_offers.settings.provinces_enabled') && $offer->contact_data()->address->province): ?>
									<div class="province">
										<label><?php echo ___('province') ?>: </label>
										<span><?php echo $offer->contact_data()->address->province ?></span>
									</div>
									<?php if($offer->contact_data()->address->county): ?>
									<div class="county">
										<label><?php echo ___('county') ?>: </label>
										<span><?php echo $offer->contact_data()->address->county ?></span>
									</div>
									<?php endif ?>
									<?php endif ?>

									<br/>

									<?php if ($offer->contact_data()->phone): ?>
									<div class="phone">
										<label><?php echo ___('telephone') ?>:</label>
										<span><?php echo offers::curtain($offer, 'telephone', 'telephone.curtain') ?></span>
									</div>
									<?php endif ?>

									<?php if ( ! Kohana::$config->load('modules.site_offers.settings.email_view_disabled') && $offer->contact_data()->email): ?>
									<div class="email">
										<label><?php echo ___('email') ?>:</label>
										<span><?php echo offers::curtain($offer, 'email', 'email.curtain') ?></span>
									</div>
									<?php endif ?>

									<?php if ($offer->contact_data()->www): ?>
									<div class="www">
										<label><?php echo ___('www') ?>:</label>
										<span><a href="<?php echo Tools::link($offer->contact_data()->www) ?>" target="_blank"><?php echo URL::idna_decode($offer->contact_data()->www) ?></a></span>
									</div>
									<?php endif ?>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<?php if($offer->coupon_expiration): ?>
				<tr>
					<td style="font-weight: bold;font-size: 13px;">
						<?php echo ___('offers.show.coupon_dates', array(
							':from' => date('Y-m-d', strtotime($offer->offer_date_added)),
							':to' => date('Y-m-d', strtotime($offer->coupon_expiration)),
						)) ?>
					</td>
				</tr>
				<?php endif; ?>
				<tr>
					<td style="color: #01619F; font-weight: bold;font-size: 13px;">
						<?php echo ___('offers.show.coupon_code') ?>: <?php echo $coupon_owner->token ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<div style="color: #898989; margin: 10px 0px; line-height: 26px; font-size: 14px; font-weight: bold;"><?php echo ___('offers.show.offer_content') ?>:</div>
<div style=" color: #5C5C5C; font-size: 12px;"><?php echo $offer->offer_content ?></div>
