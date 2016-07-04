<?php
$document = Pages::get('catalog.choose_promotion');

$replacements = array();
$types = new Catalog_Company_Promotion_Types();
foreach($types->get_promotions_enabled() as $promotion_type)
{
	$replacements['%'.$promotion_type->get_slug().'.title%'] = $promotion_type->get_title();
	$replacements['%'.$promotion_type->get_slug().'.url%'] = Route::url('site_catalog/profile/catalog/promote', array(
		'id' => $company->pk(),
	)).'?promotion_type='.$promotion_type->get_id();
}
?>
<div id="catalog_choose_promotion_box" class="box primary">
	<h2><?php echo $document->document_title ?></h2>
	<div class="content">
		
		<?php echo strtr($document->document_content, $replacements) ?>

	</div>
</div>