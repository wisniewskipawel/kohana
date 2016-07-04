<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

if(!empty($pre_sidebar))
	echo $pre_sidebar;
?>

<?php echo Widget_Box::factory('posts/sidebar/recent')->render() ?>

<?php if(isset($is_home) AND $is_home)
	echo Widget_Box::factory('posts/home_top_right')->render() ?>

<?php echo Widget_Box::factory('posts/motto')->render() ?>

<?php echo ads::show(ads::PLACE_J) ?>

<?php echo Widget_Box::factory('posts/popular')->render() ?>

<?php if(Posts::config('add_user_post')): ?>
<a href="<?php echo Route::url('site_posts/frontend/posts/add') ?>" class="add_article_btn">
	<span><?php echo ___('posts.add_btn') ?></span>
</a>
<?php endif; ?>

<?php if(Posts::config('events.enabled')) echo Widget_Box::factory('events/calendar')->render() ?>

<?php if(Modules::enabled('site_galleries')) echo Widget_Box::factory('galleries/sidebar/last')->render() ?>

<?php echo ads::show(ads::PLACE_POSTS_A, 9999, 'frontend/ads/show_inline') ?>

<?php if(!(isset($disable_widget_polls_single) AND $disable_widget_polls_single))
	echo Widget_Box::factory('polls/single')->render();
?>

<?php if($fb_widget = Kohana::$config->load('modules.site_posts.settings.fb_widget.contents')): ?>
<div class="fb_widget">
	<?php echo $fb_widget ?>
</div>
<?php endif; ?>

<?php if($custom_box_contents = Kohana::$config->load('modules.site_posts.settings.custom_box.contents')): ?>
<div id="posts_custom_box" class="box">
	<div class="box-header"><?php echo Kohana::$config->load('modules.site_posts.settings.custom_box.header') ?></div>
	<div class="content">
		<?php echo $custom_box_contents ?>
	</div>
</div>
<?php endif; ?>

