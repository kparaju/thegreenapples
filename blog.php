<?php
/*
Template Name: Blog
*/
get_header();
?>

<div class="row content blogposts">
	<?php
		while (have_posts()) : the_post();
			get_template_part( 'content', 'page' );
			?>
			<hr />
			<?php
		endwhile;
	?>
</div>

<hr />
<?php
get_template_part('bignav');
get_footer();
