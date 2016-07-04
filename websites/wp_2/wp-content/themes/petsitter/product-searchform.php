<form role="search" method="get" id="searchform" class="search-form clearfix" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
	<div class="form-group">
		<label for="name" class="sr-only"><?php _e( 'Search...', 'petsitter' ); ?></label>
		<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" class="form-control" placeholder="<?php _e( 'Search for products', 'petsitter' ); ?>" />
		<button class="btn"><i class="fa fa-search"></i></button>
		<input type="hidden" name="post_type" value="product" />
	</div>
</form>