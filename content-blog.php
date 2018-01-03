<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header><h1><?php the_title(); ?></h1></header>
  
  <div class="entry-content">
    <?php the_content(); ?>
  </div>

  <small>Posted on <?php echo get_post_time('l, F j Y') ?> </small>
</article>

<hr />