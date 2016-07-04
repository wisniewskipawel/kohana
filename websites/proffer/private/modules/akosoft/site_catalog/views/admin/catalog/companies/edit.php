<h2><?php echo ___('catalog.admin.companies.edit.title') ?></h2>

<div class="box">

	<h3><?php echo ___('catalog.admin.categories.title') ?></h3>

	<?php foreach ($categories as $c): ?>
		<p>
			<a href="<?php echo URL::site('/admin/catalog/categories/index/' . $c->category_id) ?>"><?php echo $c->category_name ?></a>
		</p>
	<?php endforeach ?>

	<h3><?php echo ___('catalog.admin.companies.edit.title') ?></h3>

	<?php echo $form ?>

	<?php if ($logo = $company->get_logo()): ?>

		<h3><?php echo ___('catalog.company_logo.edit') ?></h3>

		<div class="gallery">

			<div class="image">
				<img src="<?php echo $logo->get_url('catalog_company_list') ?>" alt="" border="0" class="">
				<p>
					<a title="<?php echo ___('images.delete.confirm') ?>" class="confirm" href="<?php echo URL::site('admin/catalog/companies/delete_logo/'.$company->pk().'?image_id='.$logo->get_id()) ?>"><?php echo ___('admin.table.delete') ?></a>
				</p>
			</div>

		</div>

	<?php endif ?>

	<h3><?php echo ___('catalog.company_logo.change') ?></h3>

	<?php echo $form_logo ?>

	<?php if(count($images)): ?>
	<h3><?php echo ___('images.edit') ?></h3>

	<div class="gallery">

		<?php foreach ($images as $image): ?>
		<div class="image">
			<img src="<?php echo $image->get_url('catalog_company_list') ?>" alt="" border="0" class="">
			<p>
				<a title="<?php echo ___('images.delete.confirm') ?>" class="confirm" href="<?php echo URL::site('admin/catalog/companies/delete_image/'.$company->pk().'?image_id='.$image->get_id()) ?>"><?php echo ___('admin.table.delete') ?></a>
			</p>
		</div>
		<?php endforeach ?>

	</div>
	<?php endif; ?>
	
	<div class="clear"></div>

	<h3><?php echo ___('images.add') ?></h3>

	<?php echo $form_images ?>

	<div id="confirmDelete"></div>
</div>