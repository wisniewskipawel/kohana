<h2><?php echo ___('products.admin.edit.title') ?></h2>

<div class="box">

	<?php echo $form ?>
	
	<?php if(!empty($images)): ?>
	<h3><?php echo ___('images.edit') ?></h3>
	
	<div class="gallery">
	
		<?php foreach ($images as $image): ?>
		<div class="image">
			<img src="<?php echo $image->get_url('product_list') ?>" alt="" border="0" class="">
			<p>
				<a title="<?php echo ___('images.delete.confirm') ?>" class="confirm" href="<?php echo URL::site('/admin/products/delete_image/'.$product->pk().'?image_id='.$image->get_id()) ?>"><?php echo ___('images.delete_btn') ?></a>
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