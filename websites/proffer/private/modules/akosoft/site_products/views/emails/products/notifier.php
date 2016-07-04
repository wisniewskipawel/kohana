<?php foreach ($products as $category_name => $array): ?>
<h3><?php echo $category_name ?></h3><br/>
<?php foreach ($array as $a): ?>
<a href="<?php echo products::url($a, 'http') ?>"><?php echo $a->annoucement_title ?></a>
(<?php echo ___('date_added') ?>: <?php echo date('Y-m-d', strtotime($a->annoucement_date_added)) ?>, <?php echo ___('category') ?>: <?php echo $a->category_name ?> )
<br/>
<?php endforeach; ?>
<br/><br/>
<?php endforeach; ?>
