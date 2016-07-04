<div id="profile_box" class="box primary">
	<h2><?php echo ___('profile.title') ?></h2>
	<div class="content">
		
		<div id="profile_settings_box" class="profile_box">
			<ul class="profile_nav">
				<li><a href="<?php echo Route::url('site_profile/profile/settings/change') ?>"><?php echo ___('profile.settings.link') ?></a></li>
				<?php $_modules = Events::fire('profile/nav', array('action' => 'settings'), TRUE);
				if(!empty($_modules)) foreach($_modules as $r): ?>
				<li><?php echo $r ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
		
		<?php 
		$_modules = Events::fire('profile/nav', array('action' => 'my'), TRUE);
		if(!empty($_modules)) 
			foreach($_modules as $r) 
				echo $r;
		?>
		
		<ul class="profile_stats">
			<?php foreach(Events::fire('profile/stats', array('user' => $current_user), TRUE) as $stats): ?>
			<?php if(!empty($stats)): ?>
			
			<?php foreach($stats as $stat): ?>
			<li><?php echo $stat['label'] ?>: <strong><?php echo $stat['value'] ?></strong></li>
			<?php endforeach; ?>
			
			<li>&nbsp;</li>
			<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</div>
</div>

<?php 
$promotions = Events::fire('profile/promotions_box', array('user' => $current_user), TRUE); 

if($promotions): ?>
<div id="profile_promotions_box" class="box primary">
	<div class="box-header"><?php echo ___('profile.promotions.title') ?></div>
	<div class="content">
		<ul class="promotions_list">
		<?php foreach($promotions as $promotion): ?>
			<li><?php echo $promotion ?></li>
		<?php endforeach; ?>
		</li>
	</div>
</div>
<?php endif; ?>

<div class="clearfix"></div>