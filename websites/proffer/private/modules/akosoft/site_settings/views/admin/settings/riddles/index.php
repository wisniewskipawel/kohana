<h2><?php echo ___('settings.security.riddles.title') ?></h2>

<div class="box">

	<div class="box_actions">
		<?php echo HTML::anchor('admin/riddles/add', ___('settings.security.riddles.add.btn'), array('class' => 'button')) ?>
	</div>
	
	<?php if(!empty($riddles)): ?>
	<table class="table tablesorter">
		<thead>
			<tr>
				<th><?php echo ___('settings.security.riddles.question') ?></th>
				<th><?php echo ___('settings.security.riddles.answers') ?></th>
				<th><?php echo ___('admin.table.actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($riddles as $index => $riddle): ?>
				<tr>
					<td><?php echo $riddle['question'] ?></td>
					<td><?php echo nl2br($riddle['answers']) ?></td>
					<td>
						<?php echo HTML::anchor(
							'admin/riddles/edit/'.$index,
							___('admin.table.edit')
						); ?>
						<?php echo HTML::anchor(
							'admin/riddles/delete/'.$index,
							___('admin.table.delete')
						); ?>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	
	<div id="confirmDelete"></div>
	
	<?php else: ?>
	
	<div class="no_results">
		<?php echo ___('settings.security.riddles.no_results') ?>
	</div>
	
	<?php endif; ?>
</div>