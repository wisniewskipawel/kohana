<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

$current_module = AkoSoft\Modules\AnnouncementsMoto\Helper::factory();
?>

<?php echo $current_module->widget('categories', array(
	'current_category' => Register::get('current_category'),
)) ?>

<?php if($current_module->config('map')) echo Widget_Box::factory('regions/map', array(
	'route' => $current_module->route('frontend/announcements/index'),
))->render() ?>

<?php if(Modules::enabled('site_ads')) echo ads::show(ads::PLACE_B) ?>

<?php
if(Modules::enabled('site_ads') AND $template->config('site_ads.index_box_enabled'))
{
	$ads = ORM::factory('Ad')->get_by_type_many(Model_Ad::TEXT_C, 3);
	echo View::factory('component/ads/sidebar_left')->set('ads', $ads);
}
