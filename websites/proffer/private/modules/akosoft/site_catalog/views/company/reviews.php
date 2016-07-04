<div id="about_box" class="box primary">
	<h2><?php echo ___('catalog.subdomain.reviews.title') ?></h2>
	
	<div class="content">
		<?php
		echo View::factory('frontend/catalog/reviews/show')
				->set('comments', $comments)
				->set('pagination', $pagination_comments)
				->set('company', $current_company)
		?>
	</div>
</div>

<?php echo HTML::style('media/js/libs/rateit/rateit.css'); ?>
<?php echo HTML::script('media/js/libs/rateit/jquery.rateit.min.js'); ?>