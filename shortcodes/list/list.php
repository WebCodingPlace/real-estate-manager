<?php
if ( $the_query->have_posts() ) {
	$masonry_class = ($masonry == 'enable') ? 'masonry-properties' : '';
	$total_posts = isset($attrs['posts']) ? $attrs['posts'] : 10;
	$total_properties = (isset($attrs['total_properties']) && $attrs['total_properties'] != '') ? $attrs['total_properties'] : $total_posts;

	$data_attrs = '';
	if ($images_height != '') {
		$class = $class.' rem-fixed-images';
		$data_attrs = "data-imagesheight=$images_height";
	}

	?>

	<div
		class="ich-settings-main-wrap rem-listings-wrap-ajax-<?php echo esc_attr( $ajax ); ?>"
	 	data-lstyle="<?php echo esc_attr( $style ); ?>"
	 	data-cols="<?php echo esc_attr( $class ); ?>"
	 	data-paged="<?php echo isset($paged) ? esc_attr( $paged ) : ""; ?>"
	 	data-total="<?php echo esc_attr( $total_properties ); ?>"
	>


	<?php if ($top_bar == 'enable') {
		$this->render_top_bar($style);
	} ?>
	
	<?php

	if ($ajax == 'enable') { ?>
		<input type="hidden" class="rem-ajax-query-args" value='<?php echo json_encode($attrs); ?>'>
	<?php }

	echo '<div class="row '.$masonry_class.'">';
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		echo '<div id="property-'.get_the_id().'" '.$data_attrs.' class="'.join(' ', get_post_class($class)).'">';
			do_action('rem_property_box', get_the_id(), $style);
		echo '</div>';
	}
	echo '</div>';

		/* Restore original Post Data */
		wp_reset_postdata();
		if ($pagination == 'enable') {
			do_action( 'rem_pagination', $paged, $the_query->max_num_pages );
		}
	?>
	</div>
	<?php
} else {
	$msg = rem_get_option('no_results_msg', esc_attr_e( 'No Properties Found!', 'real-estate-manager' ));
	echo stripcslashes($msg);
}
?>