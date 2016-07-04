<div class="box primary">
	<h2><?php echo $document->document_title ?></h2>
	<div class="content">
		<div class="text">
			<?php echo $document->document_content ?>
		</div>
	</div>
</div>

<?php if ($document->document_alias == 'contact'): ?>
	<div class="box primary">
		<h2><?php echo ___('documents.contact.form') ?></h2>
		<div class="content">
			<?php echo $form ?>
		</div>
	</div>
<?php endif; ?>
