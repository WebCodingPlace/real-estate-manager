<?php

// CFD Note: Nearby Properties is exclusive to Google Maps, so 'map_id' will never be 'Leaflet'.
// Override internal $map_id with what might be in the $attrs, defaulting to map-canvas
$mapID = isset( $attrs['map_id'] ) ? $attrs['map_id'] : 'map-canvas' ;
$mapID = str_replace("-", "_", $map_id); // CFD Note: Preventing invalid IDs

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

	$counter = 0;
	foreach ($p_l_arr as $distance => $p_id) {
		if ($counter < $total_properties) {
			$author_id = get_the_author_meta('ID');
			$author_info = get_userdata($author_id);
			$property_price = get_post_meta($p_id, 'rem_property_price', true);
			$status = get_post_meta($p_id, 'rem_property_status', true);
			$area = get_post_meta($p_id, 'rem_property_area', true);
			$bathrooms = get_post_meta( $p_id, 'rem_property_bathrooms', true );
			$address = get_post_meta($p_id, 'rem_property_address', true);
			$bedrooms = get_post_meta( $p_id, 'rem_property_bedrooms', true );
			$type = get_post_meta($p_id, 'rem_'.$filter_by_key, true);
			$latitude = get_post_meta($p_id, 'rem_property_latitude', true);
			$longitude = get_post_meta($p_id, 'rem_property_longitude', true);

			$map_meta_by = get_post_meta($p_id, 'rem_'.$icons_by_meta, true);
			if (isset($map_icons[$map_meta_by]['static'])) {
				$active_map_pin = $map_icons[$map_meta_by]['static'];
			} else {
				$active_map_pin = rem_get_option('maps_property_image', REM_URL . '/assets/images/maps/cottage-pin.png');
			}

			if (isset($map_icons[$map_meta_by]['hover'])) {
				$hover_map_pin = $map_icons[$map_meta_by]['hover'];
			} else {
				$hover_map_pin = rem_get_option('maps_property_image_hover', REM_URL . '/assets/images/maps/cottage-hover-pin.png');
			}

			$property_data = array(
				'id' 			=> $p_id,
				'title' 		=> get_the_title(),
				'description' 	=> get_the_excerpt($p_id),
				'icon_url' 		=> $active_map_pin,
				'icon_url_hover' => $hover_map_pin,
				'property_box' 	=> $this->map_box($p_id),
				'propertyType' 	=>  $type,
				'lat' 			=>  $latitude,
				'lon' 			=>  $longitude,
			);

			$all_properties[] = $property_data;
		}
		$counter++;
	}

rem_load_bs_and_fa();
rem_load_basic_styles();
wp_enqueue_style( 'rem-maps-css', REM_URL . '/assets/front/css/maps.css' );
$maps_api = apply_filters( 'rem_maps_api', 'AIzaSyBbpbij9IIXGftKhFLMHOuTpAbFoTU_8ZQ' );
if (is_ssl()) {
    wp_enqueue_script( 'rem-gmap-api-js', 'https://maps.google.com/maps/api/js?key='.$maps_api);
} else {
    wp_enqueue_script( 'rem-gmap-api-js', 'http://maps.google.com/maps/api/js?key='.$maps_api);
}
wp_enqueue_script( 'rem-infobox', REM_URL . '/assets/front/lib/infobox.js', array('jquery'));
wp_enqueue_script( 'rem-home-maps', REM_URL . '/assets/front/lib/home-maps.js', array('jquery'));
wp_enqueue_script( 'rem-markerclusterer', REM_URL . '/assets/front/lib/markerclusterer.js', array('jquery'));

$mapsData = array(
	'theme_path' => REM_URL.'/assets/',
	'properties' => $all_properties,
	'water_color' => $water_color,
	'fill_color' => $fill_color,
	'poi_color' => $poi_color,
	'poi_color_hue' => $poi_color_hue,
	'roads_lightness' => $roads_lightness,
	'lines_lightness' => $lines_lightness,
	'zoom_level' => rem_get_option('maps_zoom_level', '15'),
	'def_lat' => rem_get_option('default_map_lat', '-33.890542'),
    'def_long' => rem_get_option('default_map_long', '151.274856'),
	'my_location_icon' => $my_location_icon,
	'maps_styles' => stripcslashes(rem_get_option('maps_styles')),
	'found_text' => __( 'Found', 'real-estate-manager' ),
);

if ($def_lat != '') {
	$mapsData['def_lat'] = $def_lat;
}
if ($def_long != '') {
	$mapsData['def_long'] = $def_long;
}
if ($map_zoom != '') {
	$mapsData['zoom_level'] = $map_zoom;
}
$markerClusterData = array(
	'theme_path' => REM_URL.'/assets/',
	'circle_icon' => $circle_icon,
);
wp_localize_script( 'rem-home-maps', 'mapsData_'.$mapID, $mapsData );
wp_localize_script( 'rem-markerclusterer', 'markerClusterData', $markerClusterData );

$mapStyle = "<style>
	#{$mapID}.rem-maps .map {
		height: {$map_height};
	}
	#{$mapID}.rem-maps .find-result, #{$mapID}.rem-maps .find-result:after {
		background-color: {$btn_bg_color} !important;
		color: {$btn_text_color} !important;
	}
	#{$mapID}.rem-maps .control-left-wrapper div:after, #{$mapID}.rem-maps .control-right-wrapper div:after {
		background-color: {$btn_bg_color};
		border: none;
		color: {$btn_text_color};
		border-radius: 0;
		font-size: 20px;
	}
	#{$mapID}.rem-maps .find-result, #{$mapID}.rem-maps .find-result:after, #{$mapID} .ads-type a.item-type {
		background-color: {$btn_bg_color};
		color: {$btn_text_color};
	}
	#{$mapID}.rem-maps .control-left-wrapper div:hover:after,
	#{$mapID}.rem-maps .control-right-wrapper div:hover:after,
	#{$mapID} .ads-type a.item-type.item-selected,
	#{$mapID} .ads-type a.item-type:hover {
		background-color: {$btn_bg_color_hover};
		color: {$btn_text_color_hover};
	}
	#{$mapID} .ads-type {
		background-color: {$type_bar_bg_color};
	}
	#{$mapID}.rem-maps .loading-container .spinner {
		background-color: {$loader_color} !important;
	}
	#{$map_id}.rem-maps .rem-filters-overlay {
		background-color: {$filter_bg};
	}	
</style>";
 
echo $mapStyle;
?>
<div class="ich-settings-main-wrap">
	<section id="<?php echo esc_attr($mapID); ?>" class="rem-maps">
		<div class="loading-container">
			<div class="spinner"></div>
			<div class="text">
				<span><?php echo esc_attr($load_heading); ?></span>
				<?php echo esc_attr($load_desc); ?>
			</div>
		</div>
		<div class="find-result"></div>
		<div class="map map-home"></div>
		<?php if ($type_filtering == 'enable') { $all_types = explode(",", $filter_options); ?>
			<div class="rem-filters-overlay" id="filtering-<?php echo esc_attr($map_id); ?>">
				<?php foreach ($all_types as $p_type) { ?>
					<label><input type="checkbox" name="filter_by" value="<?php echo esc_attr($p_type); ?>" data-type="<?php echo esc_attr($p_type); ?>"> <?php echo esc_attr($p_type); ?> </label>
				<?php } ?>
			</div>
		<?php } ?>		
	</section>
</div>