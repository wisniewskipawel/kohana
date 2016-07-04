<?php foreach ($offers as $category_name => $array): ?>
<h3><?php echo $category_name ?></h3><br/>
<?php foreach ($array as $a): ?>
<a href="<?php echo Route::url('site_offers/frontend/offers/show', array('offer_id' => $a->pk(), 'title' => URL::title($a->offer_title)), 'http') ?>"><?php echo $a->offer_title ?></a>
(<?php echo ___('date_added') ?>: <?php echo date('Y-m-d', strtotime($a->offer_date_added)) ?>, <?php echo ___('category') ?>: <?php echo $a->category_name ?> )
<br/>
<?php endforeach; ?>
<br/><br/>
<?php endforeach; ?>
