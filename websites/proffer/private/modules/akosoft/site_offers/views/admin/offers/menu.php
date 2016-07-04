<?php if ($auth->permissions('admin/offers/index')): ?>
<li>
	<?php echo HTML::anchor('/admin/offers', ___('offers.title')) ?>
	<ul>
		<?php if ($auth->permissions('admin/offers/add')): ?>
		<li><?php echo HTML::anchor('/admin/offers/add', ___('offers.admin.add.menu')) ?></li>
		<?php endif ?>
		
		<li><?php echo HTML::anchor('/admin/offers/index', ___('offers.admin.index.menu')) ?></li>

		<?php if ($auth->permissions('admin/offer/categories/index')): ?>
		<li>
			<?php echo HTML::anchor('/admin/offer/categories', ___('offers.admin.categories.index.title')) ?>
			<ul>
				<li><?php echo HTML::anchor('/admin/offer/categories/index', ___('offers.admin.categories.index.menu')) ?></li>
				
				<?php if ($auth->permissions('admin/offer/categories/add')): ?>
				<li><?php echo HTML::anchor('/admin/offer/categories/add', ___('offers.admin.categories.add.menu')) ?></li>
				<?php endif ?>
			</ul>
		</li>
		<?php endif ?>
		
		<?php if ($auth->permissions('admin/offer/settings/index')): ?>
		<li><?php echo HTML::anchor('/admin/offer/settings/index', ___('offers.admin.settings.title')) ?></li>
		<?php endif ?>
		
		<?php if ($auth->permissions('admin/offers/payments')): ?>
		<li>
			<a href="#"><?php echo ___('offers.admin.payments.title') ?></a>
			<ul>
				<li><?php echo HTML::anchor('/admin/offers/payments?module_name=offer_add', ___('offers.payments.offer_add.title')) ?></li>
				<li><?php echo HTML::anchor('/admin/offers/payments?module_name=offer_promote', ___('offers.distinctions.'.Model_Offer::DISTINCTION_PREMIUM_PLUS)) ?></li>
			</ul>
		</li>
		<?php endif ?>
		
	</ul>
</li>
<?php endif ?>