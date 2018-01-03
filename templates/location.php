<?php 
/*
Template Name: Locations
*/
get_header();
?>

<div class="row content">
	<?php while (have_posts()) : the_post(); ?>
		<?php get_template_part( 'content', 'page' ); ?>

		<div id="map-canvas"></div>
		<?php 
		$button_text = carbon_get_the_post_meta('crb_location_button_text');
		$button_link = carbon_get_the_post_meta('crb_location_button_link');
		$info_text = carbon_get_the_post_meta('crb_location_info_text');
		?>

		<?php if ($button_text && $button_link): ?>
			<a href="<?php echo esc_url($button_link ); ?>" class="btn-location"><?php echo $button_text ?></a>
		<?php endif ?>

		<?php if ($info_text): ?>
			<p class="info-text"><?php echo nl2br($info_text) ?></p><!-- /.info-text -->
		<?php endif ?>

		<div class="markers-search-form">
			<form role="search" method="post" class="searchform" id="location-finder"action=""> 
				<div>
					<label class="screen-reader-text" for="location"><?php _e('Search Location:', 'crb'); ?></label> 
					<input type="text" class="searchfield" value="" name="location" id="s" /> 
					<input type="submit" class="searchsubmit" value="<?php echo esc_attr(__('Search', 'crb')); ?>" />
				</div> 
			</form>
		</div><!-- /.markers-search-form -->

	<?php endwhile; ?>
</div>

<hr />
<?php
get_template_part('bignav');
get_footer();
