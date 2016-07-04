<?php echo Form::textarea($driver->html('name'), $driver->data('value'), array(
	'id' => $driver->html('id'), 
	'title' => $driver->html('title'), 
	'class' => $driver->html('class'), 
)) ?>
<?php if($driver->data('placeholders')): ?>
<ul class="editor_placeholders" data-editor-id="<?php echo $driver->html('id') ?>">
	<?php foreach($driver->data('placeholders') as $name => $description): ?>
	<li><a href="#">%<?php echo $name ?>%</a> - <?php echo $description ?></li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>
<script type="text/javascript">
$(function() {
	var editor = CKEDITOR.replace('<?php echo $driver->html('id') ?>', {
		<?php if($driver->data('editor_type') == Bform_Driver_Editor::TYPE_SIMPLE): ?>
		toolbar: [
			[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],
			[ 'Bold', 'Italic', 'Underline', 'Strike' ], ['NumberedList', 'BulletedList']
		],
		<?php elseif($driver->data('editor_type') == Bform_Driver_Editor::TYPE_ADMIN_SIMPLE): ?>
		toolbar: [
			['Source'], [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],
			[ 'Bold', 'Italic', 'Underline', 'Strike' ], ['NumberedList', 'BulletedList'],['Link']
		],
		<?php endif; ?>
		<?php if(in_array($driver->data('editor_type'), array(Bform_Driver_Editor::TYPE_ADMIN_FULL, Bform_Driver_Editor::TYPE_ADMIN_SIMPLE))): ?>
		allowedContent: true,
        contentsCss: '<?php echo URL::site('media/css/ckeditor/contents.css') ?>',
		filebrowserImageUploadUrl: "<?php echo Route::url('ckeditor/upload') ?>?type=images",
		<?php endif; ?>
		entities_latin: false,
		fillEmptyBlocks: false,
		enterMode: CKEDITOR.ENTER_BR,
		baseHref: '<?php echo URL::base('http') ?>'
	});

	editor.on( 'fileUploadRequest', function( evt ) {
		var xhr = evt.data.fileLoader.xhr;

		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	});
});
</script>