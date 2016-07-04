<?php if (! $this->is_users_rating_disabled() ): ?>
<div class="rwp-users-reviews-wrap">
<?php 
$font_size  = $this->template_field('template_box_font_size', true);
$score_size = intval( $font_size ) - 2; 
$rate_opt   = $this->template_field('template_user_rating_options', true);
$auth 		= $this->preferences_field('preferences_authorization', true);
$color 		= $this->template_field('template_text_color', true );
$reviews 	= $this->users_data['reviews'] ;
$sortings	= array(
	'mostRecent'  	=> __('Most recent', $this->plugin_slug),
	'topScore' 		=> __('Top score', $this->plugin_slug),
	'mostHelpful' 	=> __('Most helpful', $this->plugin_slug),
	'worstScore'	=> __('Worst score', $this->plugin_slug),
)
?>

	<span 
        class="rwp-people-label" 
        style="color: <?php $this->template_field('template_users_reviews_label_color') ?>; 
        	   font-size: <?php $this->template_field('template_users_reviews_label_font_size') ?>px; 
        	   line-height: <?php $this->template_field('template_users_reviews_label_font_size') ?>px;"><?php $this->template_field('template_users_reviews_label') ?>
		
		<i style="background-color: <?php $this->template_field('template_users_reviews_label_color') ?>;
				  font-size: <?php echo $score_size ?>px;
				  border-radius: <?php echo $score_size ?>px;	
				  -webkit-border-radius: <?php echo $score_size ?>px;" v-text="reviews.length"></i>

		<em style="color: <?php echo $color ?>; 
	               font-size: <?php echo $font_size ?>px;
	               line-height: <?php echo $font_size ?>px;">
		<?php if ( $this->already_rated() ): ?>
			<?php _e('You already reviewed the item', $this->plugin_slug) ?>
		<?php elseif( $auth == 'logged_in' && !is_user_logged_in() ): ?>
			<?php 
				$custom_url = $this->preferences_field('preferences_custom_login_link', true);
				$url = empty( $custom_url ) ? wp_login_url( get_permalink() ) : $custom_url;
			?>
			<a href="<?php  echo esc_url( $url ) ?>"><?php $this->template_field('template_message_to_rate_login') ?></a>
		<?php else: ?>
			<a href="#rwp-ratings-form-<?php echo $this->post_id ?>-<?php $this->review_field('review_id') ?>"><?php $this->template_field('template_message_to_rate') ?></a>
		<?php endif ?>
		</em>
    </span>

	<span class="rwp-loading-icon" v-show="loading"></span><!-- /loader-->	

    <div class="rwp-users-reviews-toolbar" v-show="reviews.length > 0" >
    	<span><?php _e('Sort by:', $this->plugin_slug); echo ' '; ?></span>
    	<select v-on:change="sortReviews" v-model="sorting">
    		<?php foreach ($sortings as $key => $value): ?>
    			<option value="<?php echo $key ?>"><?php echo $value ?></option>
    		<?php endforeach ?>
    	</select>
    </div><!-- /users reviews toolbar -->

    <div class="rwp-users-reviews">
		<p v-show="!loading && success && reviews.length < 1"><?php _e( 'Be the first to leave a review.', $this->plugin_slug) ?></p>
		<p v-show="!loading && !successs" v-text="errorMsg"></p>
		<div class="rwp-u-review" v-bind:class="{'--rwp-highlighted': review.rating_highlighted}" v-for="review in reviews | orderBy sortingField sortingReversed | limitBy toShow">
			
			<rwp-tracker v-bind:highlighted="review.rating_highlighted"></rwp-tracker>	
			
			<?php $remove_margin = true; if ( in_array( 'rating_option_avatar', $rate_opt ) || in_array( 'rating_option_name', $rate_opt ) ):  $remove_margin = false; ?>
			<div class="rwp-u-review__user">
				<?php if ( in_array( 'rating_option_avatar', $rate_opt ) ): ?>
				<img class="rwp-u-review__avatar" v-bind:src="review.rating_user_avatar" alt="User Avatar"/>
				<?php endif ?>

				<?php if ( in_array( 'rating_option_name', $rate_opt ) ): ?>
				<span class="rwp-u-review__username" v-text="review.rating_user_name"></span>
				<?php endif ?>
			</div><!-- ⁄user section -->			
			<?php endif ?>

			<div class="rwp-u-review__content <?php if( $remove_margin ) echo '--rwp-no-avatar'; ?>">
				<?php if ( in_array( 'rating_option_score', $rate_opt ) ): ?>
				<div class="rwp-u-review__scores">
					<?php
					$mode = $this->preferences_field('preferences_rating_mode', true);
					switch ( $mode ) {
						case 'five_stars':
							$max 		= floatval( $this->template_field('template_maximum_score', true) );
							$min 		= floatval( $this->template_field('template_minimum_score', true) );
							$icon 		= $this->template_field('template_rate_image', true);
							
							echo '<rwp-score-5-star 
									v-bind:score="parseFloat(review.rating_overall)" 
									v-bind:min="parseFloat('. $min .')"
									v-bind:max="parseFloat('. $max .')"
									v-bind:icon="\''. $icon .'\'"></rwp-score-5-star>';
							break;

						case 'full_five_stars':
							$order 		= $this->template_field('template_criteria_order', true);
							$criteria 	= $this->template_field('template_criterias', true);
							$order		= ( $order == null ) ? array_keys( $criteria) : $order;
							$max 		= floatval( $this->template_field('template_maximum_score', true) );
							$min 		= floatval( $this->template_field('template_minimum_score', true) );
							$icon 		= $this->template_field('template_rate_image', true);
								
							foreach ($order as $x)  {
								echo '<rwp-score-star 
									v-bind:score="parseFloat(review.rating_score['. $x .'])" 
									v-bind:min="parseFloat('. $min .')"
									v-bind:max="parseFloat('. $max .')"
									v-bind:icon="\''. $icon .'\'"
									v-bind:label="\''. $criteria[ $x ]  .'\'"></rwp-score-star>';
							}
							break;

						default:
							$order 			= $this->template_field('template_criteria_order', true);
							$criteria 		= $this->template_field('template_criterias', true);
							$order			= ( $order == null ) ? array_keys( $criteria) : $order;
							$max 			= floatval( $this->template_field('template_maximum_score', true) );
							$min 			= floatval( $this->template_field('template_minimum_score', true) );
							$range 			= explode( '-', $this->template_field('template_score_percentages', true) );
							$low 			= floatval( $range[0] );
							$high 			= floatval( $range[1] );
							$color_low 		= $this->template_field('template_low_score_color', true);
							$color_high 	= $this->template_field('template_high_score_color', true);
							$color_medium 	= $this->template_field('template_medium_score_color', true);

							foreach ($order as $x)  {
								echo '<rwp-score-bar 
									v-bind:score="parseFloat(review.rating_score['. $x .'])" 
									v-bind:min="parseFloat('. $min .')"
									v-bind:max="parseFloat('. $max .')"
									v-bind:low="parseInt('. $low .')"
									v-bind:high="parseInt('. $high .')"
									v-bind:color-low="\''. $color_low .'\'"
									v-bind:color-medium="\''. $color_medium .'\'"
									v-bind:color-high="\''. $color_high .'\'"
									v-bind:label="\''. $criteria[ $x ]  .'\'"></rwp-score-bar>';
							}
							break;
					}
					?>
				</div><!-- /scores section -->					
				<?php endif ?>

				<?php if( in_array( 'rating_option_title', $rate_opt ) ): ?>
				<span class="rwp-u-review__title">{{{ review.rating_title }}}</span>	
				<?php endif ?>
				
				<?php if( in_array( 'rating_option_comment', $rate_opt ) ): ?>
				<div class="rwp-u-review__comment">{{{review.rating_comment | nl2br}}}</div>
				<?php endif ?>

				<?php if ( in_array( 'rating_option_like', $rate_opt ) || in_array( 'rating_option_share', $rate_opt ) ): ?>
				<div class="rwp-u-review__actions">
					<?php if ( in_array( 'rating_option_share', $rate_opt ) ): ?>
					<div class="rwp-u-review__sharing">
						<a v-for="url in review.rating_socials_url" v-bind:href="url" class="rwp-u-review__sharing-icon {{ '--rwp-' + $key }}" v-on:click="shareReview($event, $key)"></a>
					</div><!-- /sharing section -->
					<?php endif ?>

					<?php if ( in_array( 'rating_option_like', $rate_opt ) ): ?>
					<div class="rwp-u-review__likes">

						<div class="rwp-u-review__judge-icons">
							<span class="dashicons dashicons-yes" v-show="review.judging_ok"></span>
							<span class="dashicons dashicons-update" v-show="review.judging_loading"></span>
							<span class="dashicons dashicons-warning" v-show="review.judging_failed"></span>
						</div><!-- /judge icons section -->

						<div class="rwp-u-review__positive">
							<span class="rwp-u-review__positive-count" v-text="review.rating_helpful"></span>
							<i class="rwp-u-review__positive-icon" v-on:click="judgeReview(review, 1, <?php echo wp_get_current_user()->ID ?>)"></i>
						</div><!-- /positive section -->

						<div class="rwp-u-review__negative">
							<i class="rwp-u-review__negative-icon" v-on:click="judgeReview(review, 0, <?php echo wp_get_current_user()->ID ?>)"></i>
							<span class="rwp-u-review__negative-count" v-text="review.rating_unhelpful"></span>
						</div><!-- /positive section -->
					</div><!-- /likes section -->
					<?php endif ?>
				</div><!-- /actions section -->
				<?php endif ?>
				<p class="rwp-u-review__judge-msg" v-show="review.judging_failed" v-text="review.judging_msg"></p>
				<span class="rwp-u-review__date" v-text="review.rating_formatted_date"></span>
			</div> <!-- /content -->

		</div><!-- /user review --> 	
	
	</div> <!-- /users-reviews -->

	<span class="rwp-more-urs-btn" v-on:click="showMore" v-show="toShow < reviews.length"><?php _e('Show more', $this->plugin_slug) ?></span>

	<div class="rwp-pagination" v-show="reviews.length > itemsPerPage">
		<div class="rwp-pagination__container">
	      <span v-for="pageNumber in totalPages" v-on:click="changePage($event, pageNumber)" v-bind:class="{'rwp-pagination__current':  (currentPage === pageNumber)}">{{ pageNumber+1 }}</span>
		</div>
	</div> <!--/pagination -->

</div> <!-- /users-reviews-wrap -->

<?php endif ?>
