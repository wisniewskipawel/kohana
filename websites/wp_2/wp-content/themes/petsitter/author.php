<?php get_header(); ?>

<?php global $petsitter_data;
  
  $content_class = '';
  $sidebar_class = '';

  $blog_sidebar = $petsitter_data['opt-blog-sidebar']; 
  switch ($blog_sidebar) {
    case '1':
      $content_class = 'col-md-8';
      $sidebar_class = 'col-md-3 col-md-offset-1 col-bordered';
      break;
    case '2':
      $content_class = 'col-md-8 col-md-8 col-md-offset-1 col-md-push-3';
      $sidebar_class = 'col-md-3 col-md-pull-9 col-bordered';
      break;
    case '3':
      $content_class = 'col-md-12';
      break;
  }
?>

<div id="primary" class="page-content">
  <div class="container">
    <div class="row">
      
      <main id="main" class="content <?php echo $content_class; ?>" role="main">
        <!-- Content -->
        <?php
          if(isset($_GET['author_name'])) :
            $curauth = get_userdatabylogin($author_name);
            else :
            $curauth = get_userdata(intval($author));
          endif;
        ?>
        <div class="author-info clearfix">
          <h2><?php _e('About:', 'petsitter'); ?> <?php echo $curauth->display_name; ?></h2>
          <figure class="thumb alignleft">
            <?php if(function_exists('get_avatar')) { echo get_avatar( $curauth->user_email, $size = '120' ); } /* Displays the Gravatar based on the author's email address. Visit Gravatar.com for info on Gravatars */ ?>
          </figure>
          
          <?php if($curauth->description !="") { /* Displays the author's description from their Wordpress profile */ ?>
            <p><?php echo $curauth->description; ?></p>
          <?php } ?>
        </div><!--.author-->

        <hr class="lg">

        <div id="recent-author-posts">
          <h3><?php _e('Recent Posts by', 'petsitter'); ?> <?php echo $curauth->display_name; ?></h3>
          
          <?php if ( have_posts() ) : ?>

            <div class="posts-wrapper">

            <?php /* Start the Loop */ ?>
            <?php while ( have_posts() ) : the_post(); ?>

              <?php
                get_template_part( 'content' );
              ?>

            <?php endwhile; ?>
            
            </div>

            <?php petsitter_pagination(); ?>

          <?php else : ?>

            <?php get_template_part( 'content', 'none' ); ?>

          <?php endif; ?>
          
          
        </div><!--#recentPosts-->

        <div id="recent-author-comments">
          <h3><?php _e('Recent Comments by', 'petsitter'); ?> <?php echo $curauth->display_name; ?></h3>
            <?php
              $number=5; // number of recent comments to display
              $comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_approved = '1' and comment_author_email='$curauth->user_email' ORDER BY comment_date_gmt DESC LIMIT $number");
            ?>
          <div class="list list list-square list-color-secondary">
            <ul>
              <?php
                if ( $comments ) : foreach ( (array) $comments as $comment) :
                echo  '<li class="recentcomments">' . sprintf(__('%1$s on %2$s', 'petsitter'), get_comment_date(), '<a href="'. get_comment_link($comment->comment_ID) . '">' . get_the_title($comment->comment_post_ID) . '</a>') . '</li>';
              endforeach; else: ?>
                <p>
                  <?php _e('No comments by', 'petsitter'); ?> <?php echo $curauth->display_name; ?> <?php _e('yet.', 'petsitter'); ?>
                </p>
              <?php endif; ?>
            </ul>
          </div>
        </div><!--#recentAuthorComments-->
      </main><!-- #main -->

      <?php if( $blog_sidebar != 3) : ?>

      <hr class="visible-sm visible-xs lg">

      <div id="sidebar" class="sidebar <?php echo $sidebar_class; ?>">
        <?php get_sidebar(); ?>
      </div>

      <?php endif; ?>
    </div>
  </div>  
</div><!-- #primary -->

<?php get_footer(); ?>