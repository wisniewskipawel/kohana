<div class="box primary">
	<h2><?php echo ___('offers.add.title') ?></h2>
	<div class="content">

		<ul class="steps">
			<li class="<?php if ($auth->is_logged() && !$has_promoted_companies): ?>active<?php endif ?>"><span class="number">1</span><span class="text"><?php echo ___('offers.add.steps.logged') ?></span></li>
			<li class="<?php if ( ! $auth->is_logged()): ?>active<?php endif; ?>"><span class="number">2</span><span class="text"><?php echo ___('offers.add.steps.not_logged') ?></span></li>
			<li class="<?php if ($has_promoted_companies): ?>active <?php endif; ?>last"><span class="number">3</span><span class="text"><?php echo ___('offers.add.steps.company') ?></span></li>
		</ul>
		
		<div class="clearfix"></div>
		
		<?php echo $form ?>
	</div>  <!-- end .box-body -->
</div>