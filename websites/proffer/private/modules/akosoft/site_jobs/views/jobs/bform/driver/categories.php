<?php 
$i = 0; 
$opened = array(); 
$categories = $driver->data('categories');
$checked = (array)$driver->get_value();

foreach ($categories as $main_category): ?>

	<?php if ($i % 3 == 0): ?>
	<?php $opened[] = $main_category->category_id ?>
	<div class="row<?php if (count($categories) - $i <= 3):?> last <?php endif ?>">
	<?php endif ?>

	<div class="category<?php if ($i % 3 == 2):?> last<?php endif ?>">
		<div class="main_category">
			<?php echo $main_category->category_name ?>
			<?php echo Form::checkbox('categories[]', $main_category->category_id, in_array($main_category->category_id, $checked)) ?>
		</div>
		
		<?php if ($main_category->subcategories): ?>
			<?php $j = 1; ?>
			<ul>
				<?php $count_subcategories = $main_category->subcategories; foreach ($main_category->subcategories as $subcategory): ?>
				<li<?php if ($j === 1): ?> class="first"<?php endif ?><?php if ($j === 5 OR ($j < 5 AND $j === $count_subcategories)): ?> class="last"<?php endif ?> id="menu_category-<?php echo $subcategory->category_id ?>" <?php if ($j > 5): ?>style="display: none;"<?php endif ?>>
					<span class="category_name"><?php echo $subcategory->category_name ?></span>
					<?php echo Form::checkbox('categories[]', $subcategory->category_id, (in_array($subcategory->category_id, $checked))) ?>
				</li>
				<?php $j++ ?>
				<?php endforeach ?>
			</ul>
			
			<?php if ($j > 6): ?>
			<a href="#" class="more"><span><?php echo ___('more') ?></span></a>
			<?php endif ?>
		<?php endif ?>
			
	</div>
	<?php if ($i % 3 == 2):?>
		<?php array_pop($opened) ?>
		</div>
	<?php endif ?>
	<?php $i++ ?>
<?php endforeach ?>

<?php if (count($opened)): ?>
	</div>
<?php endif ?>
