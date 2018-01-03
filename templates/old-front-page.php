<?php
/*
Template Name: Old Front Page
*/
get_header();
?>
<div class="row">
	<div class="frontpage-featured">
		<img src="<?php bloginfo('stylesheet_directory'); ?>/img/reforming_education.png" alt="" />

	</div>
	<div class="frontpage-featured-nav">
		<?php
		wp_nav_menu(array(
		    'theme_location' => 'frontpage-featured-nav',
		    'depth' => 1
		)); ?>
	</div>
</div>

<div class="homevideo">
<iframe width="100%" height="500" src="https://www.youtube.com/embed/VHDQTNY9oAg?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
</div>

<div class="row tagline">
	Effective Ed promotes ways to achieve healthier communities, a cleaner environment, and greater energy savings starting with the improvement of our local schools.
</div>


<?php get_template_part('bignav'); ?>

<!--
<div class="row frontpage-blog">
	<div class="col-md-10 col-md-offset-1 fpblog-title">
		the green apples blog
	</div>

	<div class="col-md-offset-1 col-md-5">
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent nulla enim, porttitor non sollicitudin sit amet,
		venenatis vel arcu. Maecenas malesuada risus ac bibendum euismod. Maecenas vitae massa aliquet, auctor sem ac,
		luctus nibh. Nullam bibendum mi vel odio dictum sodales.
	</div>
	<div class="col-md-5">
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent nulla enim, porttitor non sollicitudin sit amet,
		venenatis vel arcu. Maecenas malesuada risus ac bibendum euismod. Maecenas vitae massa aliquet, auctor sem ac,
		luctus nibh. Nullam bibendum mi vel odio dictum sodales.
	</div>

	<div class="col-md-10 col-md-offset-1 fpblog-footer">
		visit our blog to read more
	</div>
</div>
-->
<?php
get_footer();
