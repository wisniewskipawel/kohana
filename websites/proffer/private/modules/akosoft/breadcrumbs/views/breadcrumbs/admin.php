<?php $i = 1; ?>
<?php foreach ($path as $name => $url): ?>
	<?php if ($i != $count): ?>
		&raquo; <a href="<?php if ($url != '#'): ?><?php echo URL::site($url)  ?><?php else: ?>#<?php endif ?>"><?php echo ___($name) ?></a>
	<?php else: ?>
		&raquo; <span class="bold red"><?php echo ___($name) ?></span>
	<?php endif; ?>
	<?php $i++; ?>
<?php endforeach; ?>