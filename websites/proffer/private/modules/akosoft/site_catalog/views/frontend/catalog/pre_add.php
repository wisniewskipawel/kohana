<div class="box primary add-company">
	<h2><?php echo $document->document_title ?></h2>
	<div class="content">
		<div>
			<?php echo $document->document_content ?>
		</div>

		<div class="choose">
			<?php foreach($types as $type): ?>
				<a href="<?php echo Route::url('site_catalog/frontend/catalog/add').'?type='.$type->get_id() ?>" class="button">
					<?php echo $type->get_title() ?>
				</a>
			<?php endforeach ?>
		</div>
		
		<div class="clearfix"></div>

	</div>
</div>