<h2><?php echo ___('modules.title') ?></h2>

<div class="box">

	<div class="clear"></div>

	<table class="table tablesorter">
		<thead>
			<tr>
				<th><?php echo ___('modules.name') ?></th>
				<th><?php echo ___('modules.description') ?></th>
				<th><?php echo ___('modules.enabled') ?></th>
				<th><?php echo ___('admin.table.actions') ?></th>
			</tr>
		</thead>
		<?php foreach ($modules as $m): if(!$m->can_disable()) continue; ?>
			<tr>
				<td><?php echo $m->get_title() ?></td>
				<td><?php echo $m->description() ?></td>
				<td>
					<?php if ($m->is_enabled()): ?>
					<?php echo ___('modules.enabled.yes') ?>
					<?php else: ?>
					<?php echo ___('modules.enabled.no') ?>
					<?php endif ?>
				</td>
				<td>
					<?php if ($m->is_enabled()): ?>
					<a class="confirm" title="<?php echo ___('modules.disable.confirm') ?>" href="<?php echo URL::site('/admin/modules/disable?name=' . $m->get_name()) ?>"><?php echo ___('modules.disable') ?></a>
					<?php else: ?>
					<a href="<?php echo URL::site('/admin/modules/enable?name=' . $m->get_name()) ?>"><?php echo ___('modules.enable') ?></a>
					<?php endif ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
	<div id="confirmDelete"></div>
</div>