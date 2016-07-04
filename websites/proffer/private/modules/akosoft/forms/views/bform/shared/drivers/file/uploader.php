<?php
/** @var Bform_Driver_File_Uploader $driver */

$is_uploader_js = $driver instanceof Bform_Driver_File_UploaderJS;

if($is_uploader_js)
{
	Media::js('jquery-ui-1.10.4.custom.min.js', 'js/vendor/');

	Media::css('jquery.fileupload.css', 'js/vendor/jquery-file-upload/css/');

	Media::js('load-image.min.js', 'js/vendor/jquery-file-upload/js/vendor/');
	Media::js('canvas-to-blob.min.js', 'js/vendor/jquery-file-upload/js/vendor/');
	Media::js('jquery.iframe-transport.js', 'js/vendor/jquery-file-upload/js/');
	Media::js('jquery.fileupload.js', 'js/vendor/jquery-file-upload/js/');
	Media::js('jquery.fileupload-process.js', 'js/vendor/jquery-file-upload/js/');
	Media::js('jquery.fileupload-image.js', 'js/vendor/jquery-file-upload/js/');
	Media::js('jquery.fileupload-validate.js', 'js/vendor/jquery-file-upload/js/');
	Media::js('uploader.js');
}

$amount = $driver->data('amount');
$uploaded_files = $driver->get_files();
$type = $driver->data('type');
?>
<div class="file_uploader">
	<div class="uploaded_files files_container">
		<?php if(count($uploaded_files) > 0): ?>
			<?php foreach($uploaded_files as $file): if($file instanceof Bform_File_Detached):
				$downloadUrl = $file->getDownloadUrl();
				?>
				<div class="file file--<?php echo $type ?>">
					<?php if($type == Bform_Driver_File_UploaderJS::TYPE_IMAGES AND $downloadUrl): ?>
						<div class="image-wrapper">
							<a href="<?php echo $downloadUrl ?>" class="showGallery">
								<?php echo HTML::image($downloadUrl) ?>
							</a>
						</div>
					<?php else: ?>
						<div class="file_name">
							<?php if($downloadUrl): ?>
								<a href="<?php echo $downloadUrl ?>">
									<?php echo HTML::chars($file->getClientFilename()) ?>
								</a>
							<?php else: ?>
								<?php echo HTML::chars($file->getClientFilename()) ?>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php echo Form::hidden('_uploaded_files[]', $driver->file_info_encode($file->asFileInfoArray())) ?>
					<a href="<?php echo $file->getRemoveUrl() ?: '#' ?>" class="close">&times;</a>
				</div>
				<?php $amount--; endif; endforeach; ?>
		<?php endif; ?>
	</div>

	<?php if($driver->html('html_before')): ?>
		<div class="html-before"><?php echo $driver->html('html_before') ?></div>
	<?php endif; ?>

	<div class="upload_files">

		<div class="alert alert-info"><?php echo ___('bform.driver.file_uploaderjs.limits', $driver->data('amount'), array(
				':size' => Num::pretty_size(Kohana::$config->load('img.max_upload_size')),
				':limit' => $driver->data('amount'),
			)) ?></div>

		<?php if($amount > 0): ?>
			<div class="file_inputs">
				<?php if($amount == 1): ?>
					<?php echo Form::file($driver->data('name')) ?>
				<?php else: for($i=0; $i<$amount; $i++): ?>
					<?php echo Form::file($driver->data('name').'[]') ?>
				<?php endfor; endif; ?>
			</div>
		<?php endif; ?>

		<?php if($is_uploader_js): ?>
		<div class="fileuploader" style="display: none;">
			<span class="btn btn-default fileinput-button">
				<i class="glyphicon glyphicon-plus"></i>
				<span><?php echo ___('bform.driver.file_uploaderjs.choose_files') ?></span>
				<input class="filesuploader-input" type="file" name="<?php echo $driver->data('name').'[]' ?>" multiple data-file_limit="<?php echo $driver->data('amount') ?>" data-upload_url="<?php echo URL::site(Request::current()->uri(), 'http').URL::query(array('fileuploader' => 1)) ?>">
			</span>
		</div>
		<?php endif; ?>
	</div>

	<?php if($driver->html('html_after')): ?>
		<div class="html-after"><?php echo $driver->html('html_after') ?></div>
	<?php endif; ?>
</div>