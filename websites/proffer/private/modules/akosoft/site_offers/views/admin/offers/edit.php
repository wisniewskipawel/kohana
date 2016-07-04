<h2><?php echo ___('offers.admin.edit.title') ?></h2>

<div class="box">
	
	<h3><?php echo ___('offers.admin.edit.title') ?></h3>

	<?php echo $form ?>
	
	<?php if(count($images)): ?>
	<h3><?php echo ___('images.edit') ?></h3>
	
	<div class="gallery">
	
		<?php foreach ($images as $image): ?>
		<div class="image">
			<img src="<?php echo $image->get_url('offer_list') ?>" alt="" border="0" class="">
			<p>
				<a title="<?php echo ___('images.delete.confirm') ?>" class="confirm" href="<?php echo URL::site('admin/offers/delete_image/'.$offer->pk().'?image_id='.$image->get_id()) ?>"><?php echo ___('images.delete_btn') ?></a>
			</p>
		</div>
		<?php endforeach ?>
			
	</div>
	<?php endif ?>
	
	<div class="clear"></div>
	
	<h3><?php echo ___('images.add') ?></h3>
	
	<?php echo $form_images ?>
	
	<div id="confirmDelete"></div>

</div>