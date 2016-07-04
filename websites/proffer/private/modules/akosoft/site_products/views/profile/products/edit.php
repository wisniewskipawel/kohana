<div class="box primary">
	<h2><?php echo ___('products.profile.edit.title') ?></h2>
	<div class="content">
		<?php echo $form ?>
	</div>
</div>

<div class="box gray">
	<h2><?php echo ___('images.add') ?></h2>
	<div class="content">
		<?php echo $form_images; ?>
	</div>
</div>

<?php if(count($images)): ?>
<div class="box gray">
	<h2><?php echo ___('images.delete') ?></h2>
	<div class="content">
		<div class="product-edit-images edit_images">	  
			<?php foreach ($images as $image): ?>
				<div class="image_entry">
					<div class="image-wrapper">
						<a href="<?php echo $image->get_url('product_big') ?>" class="lightbox_photo">
							<img src="<?php echo $image->get_url('product_list') ?>" alt="" border="0">
						</a>
					</div>
					<div class="actions">
						<a class="button" onclick="return confirm('<?php echo ___('images.delete.confirm') ?>')" href="<?php 
						echo Route::url('site_products/profile/products/delete_image', array(
							'image_id' => $image->get_id(),
							'product_id' => $product->pk(),
						)) ?>"><?php echo ___('images.delete_btn') ?></a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<?php endif; ?>