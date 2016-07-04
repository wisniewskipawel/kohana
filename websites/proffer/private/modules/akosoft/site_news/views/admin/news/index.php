<h2><?php echo ___('news.title') ?></h2>

<div class="box">
	
	<?php echo $pager ?>
	
	<form class="form-many" action="<?php echo URL::site('/admin/news/many') ?>" method="post">
		<table class="table tablesorter">
			<thead>
				<tr>
					<th>[x]</th>
					<th>#</th>
					<th><?php echo ___('news.forms.news_title') ?></th>
					<th><?php echo ___('date_added') ?></th>
					<th><?php echo ___('news.forms.news_is_published') ?></th>
					<th><?php echo ___('admin.table.actions') ?></th>
				</tr>
			</thead>
			<?php foreach ($news as $n): ?>
				<tr>
					<td><input type="checkbox" class="checkbox-list" name="news[]" value="<?php echo $n->news_id ?>" /></td>
					<td><?php echo $n->news_id ?></td>
					<td><?php echo $n->news_title ?></td>
					<td>
						<?php echo Date::my($n->news_date_added) ?>
					</td>
					<td>
						<?php if ($n->news_is_published): ?>
							<?php if ($n->news_visible_from > time()): ?>
								<span class="red"><?php echo ___('news.is_visible.no') ?></span>
								<br/>
								<span style="color: red;"><?php echo ___('news.is_visible.date', array(':date' => $n->when_published())) ?></span>
							<?php else: ?>
								<?php echo ___('news.is_visible.yes') ?>
							<?php endif ?>
						<?php else: ?>
							<span class="red"><?php echo ___('news.is_visible.no') ?></span>
						<?php endif ?>
					</td>
					<td>
						<?php if ($auth->permissions('admin/news/edit')): ?>
						<a href="<?php echo URL::site('/admin/news/edit/' . $n->news_id) ?>"><?php echo ___('admin.table.edit') ?></a>
						<?php endif ?>
						
						<?php if ($auth->permissions('admin/news/delete')): ?>
						<a class="confirm" title="<?php echo ___('admin.delete.confirm') ?>" href="<?php echo URL::site('/admin/news/delete/' . $n->news_id) ?>"><?php echo ___('admin.table.delete') ?></a>
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach; ?>
				
			<tfoot>
				<tr>
					<td class="arrow" colspan="7">
						
						<?php if ($auth->permissions('admin/news/delete')): ?>
						<a href="#" class="check-all"><?php echo ___('admin.table.select_all') ?></a>
						<?php echo Form::select('action', array('delete' => ___('admin.table.select.delete')), NULL, array('class' => 'form-many-actions')) ?>
						<input type="submit" value="OK" />
						<?php endif ?>
						
					</td>
				</tr>
			</tfoot>
			
		</table>
		
	</form>
	<div id="confirmDelete"></div>

	<?php echo $pager ?>

</div>