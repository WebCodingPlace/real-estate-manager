<?php
if ( $the_query->have_posts() ) { ?>
	<div class="ich-settings-main-wrap">
		<section class="wcp-slick" <?php echo esc_attr($data_attr); ?>>
			<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
				<div style="padding:10px;" class="slick-slide">
					<?php do_action('rem_property_box', get_the_id(), $style); ?>
				</div>
			<?php endwhile; ?>
		</section>					
	</div>
<?php wp_reset_postdata(); } else {
	echo __( 'No Properties Found!', 'real-estate-manager' );
}
?>