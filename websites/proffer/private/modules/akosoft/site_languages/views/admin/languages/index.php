<h2><?php echo ___('languages.title') ?></h2>

<div class="box">
	
	<h3><?php echo ___('languages.admin.available') ?></h3>
	
	<table class="table tablesorter">
		<thead>
			<tr>
				<th><?php echo ___('name') ?></th>
				<th><?php echo ___('admin.table.actions') ?></th>
			</tr>
		</thead>
		<?php foreach ($languages as $lang_key => $lang): ?>
			<tr>
				<td><?php echo $lang ?></td>
				<td>
					<?php if ($lang_key != Languages::current()): ?>
						<?php echo HTML::anchor('/admin/languages/set_default?name=' . $lang_key, ___('languages.admin.set_default.btn')) ?>
					<?php endif ?>
				</td>
			</tr>
		<?php endforeach ?>
	</table>
	
</div>