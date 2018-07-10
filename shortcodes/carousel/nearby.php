<?php
	$current_latitude = $_GET['lat'];
	$current_longitude = $_GET['long'];
	$p_l_arr = array();
	// The Loop
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$lat = get_post_meta( get_the_id(), 'rem_property_latitude', true );
				$long = get_post_meta( get_the_id(), 'rem_property_longitude', true );
				if ($lat != '') {
					$distance_p = $this->get_distance( $current_latitude, $current_longitude, $lat, $long );
					$p_l_arr[(string)$distance_p] = get_the_id();
				}
		}

		/* Restore original Post Data */
		wp_reset_postdata();			
	}

	ksort($p_l_arr, SORT_NUMERIC);

	echo '<div class="ich-settings-main-wrap">';
	echo "<section class='wcp-slick' ".$data_attr.">";
	$counter = 0;
	foreach ($p_l_arr as $distance => $p_id) {
		if ($counter < $total_properties) {
			echo '<div class="slick-slide" style="padding:10px;" id="property-'.$p_id.'">';
				do_action('rem_property_box', $p_id, $style);
			echo '</div>';
		}
		$counter++;
	}
	echo '</section>';	
	echo '</div>';

?>