<?php $i = 1; ?>
<ul class="breadcrumbs">
	<?php foreach ($path as $name => $url): 
	$title = HTML::chars(___($name));
	$url = (strlen(URL::site('/')) > 1 AND strpos($url, URL::site('/')) !== FALSE) ? $url : URL::site($url);
	?>
		<?php if ($i != $count): ?>
			<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
				<a href="<?php echo $url ?>" title="<?php echo $title ?>" itemprop="url">
					<span itemprop="title">
						<?php echo $count > 3 ? Text::limit_chars($title, 24, '...') : $title ?>
					</span>
				</a>
			</li>
		<?php else: ?>
			<li class="last"><?php echo $count > 3 ? Text::limit_chars($title, 24, '...') : $title ?><li>
		<?php endif; ?>
		<?php $i++; ?>
	<?php endforeach; ?>
</ul>