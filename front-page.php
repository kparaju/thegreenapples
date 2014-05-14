<?php
get_header();
?>
<div class="row">
	<div class="frontpage-featured">

	</div>
	<div class="frontpage-featured-nav">
		<?php
		wp_nav_menu(array(
		    'theme_location' => 'frontpage-featured-nav',
		    'depth' => 1
		)); ?>
	</div>
</div>

<div class="row tagline">
	The Green Apple promotes <strong>environmental reform</strong> to achieve a healthier community, 
	a cleaner environment, and greater energy savings starting from our local schools.
</div>


<?php get_template_part('bignav'); ?>

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
<?php
get_footer();
