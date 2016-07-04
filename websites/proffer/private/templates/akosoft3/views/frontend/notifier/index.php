<?php 
$document = Pages::get('notifier');
?>
<div class="box primary">
	<h2><?php echo $document->document_title ?></h2>
	<div class="content">

		<div>
			<?php echo $document->document_content ?>
		</div>

		<?php echo $form->render() ?>
	</div>
</div>

<div class="clearfix"></div>
