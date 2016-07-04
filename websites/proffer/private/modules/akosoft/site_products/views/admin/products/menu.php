<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

if ($auth->permissions('admin/products/index')): ?>
<li>
	<?php echo HTML::anchor('/admin/products', ___('products.title')) ?>
	<ul>
		<?php if ($auth->permissions('admin/products/add')): ?>
		<li><?php echo HTML::anchor('/admin/products/add', ___('products.admin.add.menu')) ?></li>
		<?php endif ?>
			
		<li><?php echo HTML::anchor('/admin/products/index', ___('products.admin.index.menu')) ?></li>

		<?php if($auth->permissions('admin/product/categories')): ?>
			<li>
				<?php echo HTML::anchor('/admin/product/categories', ___('products.admin.categories.title')); ?>
				<ul>
					<li><?php echo HTML::anchor('/admin/product/categories/index', ___('products.admin.categories.browse')); ?></li>
					<?php if ($auth->permissions('admin/product/categories/add')): ?>
						<li><?php echo HTML::anchor('/admin/product/categories/add', ___('products.admin.categories.add.btn')); ?></li>
					<?php endif ?>
				</ul>
			</li>
		<?php endif ?>
		
		<?php if ($auth->permissions('admin/product/types/index')): ?>
		<li><?php echo HTML::anchor('/admin/product/types', ___('products.admin.types.index.title')) ?></li>
		<?php endif ?>
			
		<?php if ($auth->permissions('admin/product/availabilities/index')): ?>
		<li><?php echo HTML::anchor('/admin/product/availabilities', ___('products.admin.availabilites.index.title')) ?></li>
		<?php endif ?>
			
		<?php if ($auth->permissions('admin/products/settings')): ?>
		<li><?php echo HTML::anchor('/admin/products/settings', ___('products.admin.settings.title')) ?></li>
		<?php endif ?>
		
		<?php if ($auth->permissions('admin/products/payments')): ?>
		<li>
			<?php echo HTML::anchor('#', ___('products.admin.payments.title')) ?>
			<ul>
				<li><?php echo HTML::anchor('/admin/products/payments?module_name=product_add', ___('products.payments.product_add.title')); ?></li>
				<li><?php echo HTML::anchor('/admin/products/payments?module_name=product_promote', ___('products.payments.product_promote.title')); ?></li>
			</ul>
		</li>
		<?php endif ?>
		
	</ul>
</li>
<?php endif ?>