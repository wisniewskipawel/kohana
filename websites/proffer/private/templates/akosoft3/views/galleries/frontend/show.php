<div id="gallery_show_box" class="box primary">
	<div class="box-header">
		<h1><?php echo HTML::chars($gallery->title) ?></h1>
	</div>
	<div class="content">
		
		<div class="meta">
						
			<span class="date_added">
				<span class="label"><?php echo ___('date_added') ?>:</span>
				<span class="value"><?php echo Date::my($gallery->date_created, 'gallery_list') ?></span>
			</span>

			<span class="images_counter">
				<span class="label"><?php echo ___('galleries.lists.images_counter') ?>:</span>
				<span class="value"><?php echo (int)$gallery->images_counter ?></span>
			</span>
			
			<?php if($gallery->author): ?>
			<span class="author">
				<span class="label"><?php echo ___('galleries.lists.author') ?>:</span>
				<span class="value"><?php echo HTML::chars($gallery->author) ?></span>
			</span>
			<?php endif; ?>
			
		</div>
		
		<?php
		$current_image = $images[$pagination->offset]
		?>
		
		<div id="big_image" class="image-wrapper">
			<?php if(img::image_exists('galleries', 'gallery_big', $current_image->pk(), $current_image->file_name)): ?>
			<?php echo HTML::image(
				img::path_uri('galleries', 'gallery_big', $current_image->pk(), $current_image->file_name),
				array('alt' => $gallery->title)
			) ?>
			<?php else: ?>
			<?php echo HTML::image('media/img/no_photo.jpg') ?>
			<?php endif; ?>
			
			<?php if($pagination->total_pages > 1): ?>
			<?php if($pagination->previous_page): ?>
			<a href="<?php echo URL::site(GalleriesUtils::uri($gallery, $pagination->previous_page, TRUE)) ?>" rel="prev" class="page_action page_prev">
				&laquo; <?php echo ___('pagination.prev') ?>
			</a>
			<?php endif; ?>
			
			<?php if($pagination->next_page): ?>
			<a href="<?php echo URL::site(GalleriesUtils::uri($gallery, $pagination->next_page, TRUE)) ?>" rel="next" class="page_action page_next">
				<?php echo ___('pagination.next') ?> &raquo;
			</a>
			<?php endif; ?>
			<?php endif; ?>
		</div>
		
		<?php if($gallery->description): ?>
		<div class="description">
			<?php echo HTML::chars($gallery->description) ?>
		</div>
		<?php endif ?>
		
		<?php if($pagination->total_pages > 1): ?>
		<div class="gallery_pagination">
			<?php if($pagination->previous_page): ?>
			<a href="<?php echo URL::site(GalleriesUtils::uri($gallery, $pagination->previous_page, TRUE)) ?>" rel="prev">
				&laquo; <?php echo ___('pagination.prev') ?>
			</a>
			<?php endif; ?>
			
			<span class="page_info">
				<strong><?php echo $pagination->current_page ?></strong> / <?php echo $gallery->images_counter ?>
			</span>
			
			<?php if($pagination->next_page): ?>
			<a href="<?php echo URL::site(GalleriesUtils::uri($gallery, $pagination->next_page, TRUE)) ?>" rel="next">
				<?php echo ___('pagination.next') ?> &raquo;
			</a>
			<?php endif; ?>
		</div>
		
		<ol class="gallery_images_list">
			<?php foreach($images as $index => $image): ?>
			<li class="<?php if($index == $pagination->offset) echo 'active' ?>">
				<div class="image-wrapper">
					<a href="<?php echo URL::site(GalleriesUtils::uri($gallery, $index+1, TRUE)) ?>">
						<?php if(img::image_exists('galleries', 'gallery_list', $image->pk(), $image->file_name)): ?>
						<?php echo HTML::image(
							img::path_uri('galleries', 'gallery_list', $image->pk(), $image->file_name),
							array('alt' => $gallery->title)
						) ?>
						<?php else: ?>
						<?php echo HTML::image('media/img/no_photo.jpg') ?>
						<?php endif; ?>
					</a>
				</div>
			</li>
			<?php endforeach; ?>
		</ol>
		<?php endif; ?>
		
		<div class="share">
			<label><?php echo ___('share') ?>:</label>
			<div class="share-buttons">
				<?php
				$share = new Share(
					URL::site(GalleriesUtils::uri($gallery), 'http'), 
					$gallery->title,
					$gallery->description
				);
				
				if(img::image_exists('galleries', 'gallery_list', $current_image->pk(), $current_image->file_name))
					$share->add_image(URL::site(img::path_uri('galleries', 'gallery_list', $current_image->pk(), $current_image->file_name), 'http'));
				
				echo $share->render();
				?>
			</div>
		</div>
		
		<?php if(isset($comments))
		{
			$comments->form_add_comment->param('layout', 'forms/comments');
			echo $comments;
		}
		?>
		
	</div>
</div>
