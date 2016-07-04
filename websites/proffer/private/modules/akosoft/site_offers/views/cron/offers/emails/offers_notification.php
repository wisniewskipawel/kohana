<div>
    <?php foreach ($offers as $a): ?>
        <div>
            <a href="<?php echo Route::url('site_offers/frontend/offers/show', array('offer_id' => $a->pk(), 'title' => URL::title($a->offer_title)), 'http') ?>"><?php echo $a->offer_title ?></a> (<?php echo ___('date_added') ?>: <?php echo $a->offer_date_added ?>, <?php echo ___('category') ?>: <a href="<?php echo Route::url('site_offers/frontend/offers/category', array('category_id' => $a->last_category_id, 'title' => URL::title($a->last_category_name)), 'http') ?>"><?php echo $a->last_category_name ?></a>)
        </div>
    <?php endforeach; ?>
</div>