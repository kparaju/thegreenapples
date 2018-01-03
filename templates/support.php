<?php
/*
Template Name: Support Page
*/

get_header();
?>

<div class="row content">
	<?php
		while (have_posts()) : the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			  <header class="hidden"><h1><?php the_title(); ?></h1></header>
			  
			  <div class="entry-content">
			    <?php 
			    the_content(); 
			    if ($selected_form = carbon_get_the_post_meta('crb_select_form')) {
			    	gravity_form($selected_form, true, false, false, false, true, 15);
			    }
			    ?>

			  </div>
			</article>
			<?php
		endwhile;
	?>
</div>

<hr />
<?php
get_template_part('bignav');
get_footer();
