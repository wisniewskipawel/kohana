<?php foreach ($jobs as $category_name => $array): ?>
<h3><?php echo $category_name ?></h3><br/>
<?php foreach ($array as $a): ?>
<a href="<?php echo URL::site(Jobs::uri($a), 'http') ?>"><?php echo $a->title ?></a>
(<?php echo ___('date_added') ?>: <?php echo date('Y-m-d', strtotime($a->date_added)) ?>)
<br/>
<?php endforeach; ?>
<br/><br/>
<?php endforeach; ?>
