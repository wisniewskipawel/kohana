<div class="box primary">
	<h2><?php echo ___('offers.profile.edit.title') ?></h2>
	<div class="content">
		<?php echo $form ?>
	</div>
</div>

<div class="box primary">
	<h2><?php echo ___('images.add') ?></h2>
	<div class="content">
		<?php echo $form_images; ?>
	</div>
</div>

<?php if(count($images)): ?>
<div class="box primary">
	<h2><?php echo ___('images.delete') ?></h2>
	<div class="content">
		<div class="offer-edit-images edit_images">	  
			<?php foreach ($images as $image): ?>
			<div class="image_entry">
				<div class="image-wrapper">
					<a href="<?php echo $image->get_url('offer_big') ?>" class="lightbox_photo">
						<img src="<?php echo $image->get_url('offer_list') ?>" alt=""/>
					</a>
				</div>
				<div class="actions">
					<?php 
					echo HTML::anchor(
						Route::get('site_offers/profile/offers/delete_image')->uri(array(
							'offer_id' => $offer->pk(),
							'image_id' => $image->get_id(),
						)),
						___('images.delete_btn'),
						array(
							'class' => 'button',
							'onclick' => "return confirm('".___('images.delete.confirm')."')",
						)
					); 
					?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<?php endif; ?>
