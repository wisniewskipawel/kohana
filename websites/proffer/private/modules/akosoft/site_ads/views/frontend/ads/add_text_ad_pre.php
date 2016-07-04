<div class="box primary">
	<h2><?php echo $document->document_title; ?></h2>
	<div class="content">
		<?php echo $document->document_content; ?>
		
		<div style="text-align: center; ">
			<?php echo HTML::anchor(
				Route::get('site_ads/frontend/ads/add_text_ad')->uri(), 
				___('ads.accept_terms'), 
				array('class' => 'btn btn-primary')
			); ?>
		</div>
		
	</div>
</div>