<div class="box primary">
	<h2><?php echo ___('catalog.profile.edit.title') ?></h2>
	<div class="content">
		<?php echo $form ?>
	</div>
</div>

<?php if(count($images)): ?>
<div class="box primary">
	<h2><?php echo ___('images.delete') ?></h2>
	<div class="content">
		<div class="company-edit-images edit_images">
			<?php foreach($images as $image): ?>
				<div class="image_entry">
					<div class="image-wrapper">
						<a href="<?php echo $image->get_url('catalog_company_big') ?>" class="lightbox_photo">
							<img src="<?php echo $image->get_url('catalog_company_list') ?>" />
						</a>
					</div>
					<div  class="actions">
						<a class="button" onclick="return confirm('<?php echo ___('images.confirm') ?>');" href="<?php echo Route::url('site_catalog/profile/catalog/delete_image', array('image_id' => $image->get_id(), 'company_id' => $company->company_id)) ?>"><?php echo ___('delete') ?></a>
					</div>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</div>
<?php endif; ?>
