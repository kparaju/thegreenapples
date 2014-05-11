<?php
get_header();
?>

<div class="row content">
	<?php
		while (have_posts()) : the_post();
			get_template_part( 'content', 'page' );
		endwhile;
	?>
</div>

<?php
get_template_part('bignav');
get_footer();
