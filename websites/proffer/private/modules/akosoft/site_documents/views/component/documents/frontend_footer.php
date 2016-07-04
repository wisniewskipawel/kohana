<ul class="footer_nav">
<?php $i = 1; ?>
<?php foreach ($documents as $d): ?>
	<li <?php if ($i == count($documents)): ?>class="last"<?php endif ?> ><a href="<?php echo Route::url('site_documents/frontend/documents/show', array('url' => $d->document->document_url)) ?>"><?php echo $d->document->document_title ?></a></li>
	<?php $i++ ?>
<?php endforeach ?>
</ul>