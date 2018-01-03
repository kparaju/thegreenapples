<?php
/*
Template Name: Simple NoNav Page
*/
get_header();
?>

<div class="row content">
	<?php
		while (have_posts()) : the_post();
			get_template_part( 'content', 'page' );
		endwhile;
	?>
</div>

<hr />
<?php
get_footer();
