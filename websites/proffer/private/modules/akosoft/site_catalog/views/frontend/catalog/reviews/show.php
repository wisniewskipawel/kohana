<div class="company_reviews" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
	
	<meta itemprop="votes" content="<?php echo $company->count_reviews ?>" />
	
	<div class="header" itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">
		<div class="average_rating">
			<label><?php echo ___('catalog.reviews.show.average') ?>:</label>
			<span>
				<div class="rateit" data-rateit-value="<?php echo $company->rating ?>" data-rateit-readonly="true"></div>
				<meta itemprop="average" content="<?php echo $company->rating ?>" />
			</span>
		</div>
		
		<div class="reviews_number">
			<label><?php echo ___('catalog.reviews.show.count_reviews') ?>:</label>
			<span><?php echo (int)$company->count_comments ?></span>
		</div>
		
		<?php echo HTML::anchor(
			catalog::url($company, 'reviews/add'),
			___('catalog.reviews.add.btn'),
			array('class' => 'add_company_review')
		); ?>
	</div>
	
	<?php if(count($comments)): ?>
	
	<?php echo $pagination ?>
	
	<?php foreach($comments as $review): ?>
	<div class="review">
		<div class="header">
			<?php if(!empty($review->comment_author)): ?>
			<div class="author">
				<label><?php echo ___('catalog.reviews.show.comment_author') ?>:</label>
				<span><?php echo HTML::chars($review->comment_author) ?></span>
			</div>
			<?php endif; ?>
			
			<div class="rating">
				<label><?php echo ___('catalog.reviews.rating') ?>:</label>
				<span>
					<div class="rateit" data-rateit-value="<?php echo $review->rating ?>" data-rateit-readonly="true"></div>
				</span>
			</div>
			
			<div class="date_added">
				<label><?php echo ___('date_added') ?>:</label>
				<span><?php echo $review->date_created ?></span>
			</div>
		</div>
		
		<div class="comment_body">
			<?php echo HTML::chars($review->comment_body) ?>
		</div>
	</div>
	<?php endforeach; ?>
	
	<?php echo $pagination ?>
	
	<?php else: ?>
	<div class="no_results">
		<?php echo ___('catalog.reviews.no_results') ?>
	</div>
	<?php endif; ?>
	
</div>
