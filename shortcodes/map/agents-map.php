<?php
foreach ($agents as $index => $agent) {

	$latitude = get_user_meta($agent->ID, 'agent_latitude', true);
	$longitude = get_user_meta($agent->ID, 'agent_longitude', true);
	if($latitude != '' && $longitude != ''){
		$agent_data = array(
			'id' 			=> $agent->ID,
			'icon_url' 		=> REM_URL . '/assets/images/maps/pin-maps.png',
			'icon_url_hover'=> REM_URL . '/assets/images/maps/pin-maps-hover.png',
			'property_box' 	=> $this->map_agent_box($agent->ID),
			'lat' 			=>  $latitude,
			'lon' 			=>  $longitude,
			'address' 			=>  '',
		);
		$all_agents[] = $agent_data;
	}
}
rem_load_bs_and_fa();
rem_load_basic_styles();
wp_enqueue_style( 'rem-maps-css', REM_URL . '/assets/front/css/maps.css' );
$maps_api = apply_filters( 'rem_maps_api', 'AIzaSyBbpbij9IIXGftKhFLMHOuTpAbFoTU_8ZQ' );
if ($use_map_from == 'leaflet') {
    wp_enqueue_style( 'rem-leaflet-css', REM_URL . '/assets/front/leaflet/leaflet.css');
    wp_enqueue_style( 'rem-m-cluster-css', REM_URL . '/assets/front/leaflet/MarkerCluster.css' );   
    wp_enqueue_style( 'rem-m-cluster-default-css', REM_URL . '/assets/front/leaflet/MarkerCluster.Default.css' );    
    wp_enqueue_script( 'rem-leaflet-js', REM_URL . '/assets/front/leaflet/leaflet.js', array('jquery'));
    wp_enqueue_script( 'rem-leaflet-markers-js', REM_URL . '/assets/front/leaflet/leaflet.markercluster.js', array('jquery'));
    wp_enqueue_script( 'rem-global-maps-js', REM_URL . '/assets/front/leaflet/custom.js', array('jquery'));
    $icons_size = rem_get_option('leaflet_icons_size', '43x47');
    $icons_anchor = rem_get_option('leaflet_icons_anchor', '18x47');    
	$mapsData = array(
		'properties' 		=> $all_agents,
		'leaflet_styles' => $leaflet_styles,
		'zoom_level' 	=> rem_get_option('maps_zoom_level', '18'),
		'def_lat' 		=> rem_get_option('default_map_lat', '-33.890542'),
        'def_long' 		=> rem_get_option('default_map_long', '151.274856'),
        'map_id' 		=> $map_id,
        'icons_size' 	=> explode("x", $icons_size),
        'icons_anchor' 	=> explode("x", $icons_anchor),
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
	wp_localize_script( 'rem-global-maps-js', 'mapsData'.$map_id, $mapsData );    
} else {
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
		'properties' => $all_agents,
		'water_color' => $water_color,
		'fill_color' => $fill_color,
		'poi_color' => $poi_color,
		'poi_color_hue' => $poi_color_hue,
		'roads_lightness' => $roads_lightness,
		'lines_lightness' => $lines_lightness,
		'zoom_level' => rem_get_option('maps_zoom_level', '15'),
		'def_lat' => rem_get_option('default_map_lat', '-33.890542'),
        'def_long' => rem_get_option('default_map_long', '151.274856'),
		'auto_center' => $auto_center,
		'maps_styles' => stripcslashes(rem_get_option('maps_styles')),
		'found_text' => __( 'Found', 'real-estate-manager' ),
		'my_pos_text' => __( 'You are here', 'real-estate-manager' ),
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
	wp_localize_script( 'rem-home-maps', 'mapsData_'.$map_id, $mapsData );
	wp_localize_script( 'rem-markerclusterer', 'markerClusterData', $markerClusterData );
}

 
$mapStyle = "<style>
	#{$map_id}.rem-maps .map {
		height: {$map_height};
	}
	#{$map_id}.rem-leaflet-map-area {
		height: 500px;
	}
	#{$map_id}.rem-leaflet-map-area .rem-box-maps:hover .price {
		top: 165px !important;
	}
	#{$map_id}.rem-leaflet-map-area {
		height: {$map_height} !important;
	}
	#{$map_id}.rem-maps .find-result, #{$map_id}.rem-maps .find-result:after {
		background-color: {$btn_bg_color} !important;
		color: {$btn_text_color} !important;
	}
	#{$map_id}.rem-maps .control-left-wrapper div:after, #{$map_id}.rem-maps .control-right-wrapper div:after {
		background-color: {$btn_bg_color};
		border: none;
		color: {$btn_text_color};
		border-radius: 0;
		font-size: 20px;
	}
	#{$map_id}.rem-maps .find-result, #{$map_id}.rem-maps .find-result:after, #{$map_id} .ads-type a.item-type {
		background-color: {$btn_bg_color};
		color: {$btn_text_color};
	}
	#{$map_id}.rem-maps .control-left-wrapper div:hover:after,
	#{$map_id}.rem-maps .control-right-wrapper div:hover:after,
	#{$map_id} .ads-type a.item-type.item-selected,
	#{$map_id} .ads-type a.item-type:hover {
		background-color: {$btn_bg_color_hover};
		color: {$btn_text_color_hover};
	}
	#{$map_id} .ads-type {
		background-color: {$type_bar_bg_color};
	}
	#{$map_id}.rem-maps .loading-container .spinner {
		background-color: {$loader_color} !important;
	}
	#{$map_id}.rem-maps .rem-filters-overlay {
		background-color: {$filter_bg};
	}
	#{$map_id} .leaflet-popup-content .rem-box-maps {margin: 0 !important;}
</style>";
 
echo wp_kses_post($mapStyle);

?>
<div class="ich-settings-main-wrap map-agents-list">
	<?php if ($use_map_from == 'google_maps') { ?>
	<section id="<?php echo esc_attr($map_id); ?>" class="rem-maps">
		<div class="loading-container">
			<div class="spinner"></div>
			<div class="text">
				<span><?php echo esc_attr($load_heading); ?></span>
				<?php echo esc_attr($load_desc); ?>
			</div>
		</div>
		<div class="find-result"></div>
		<div class="map map-home"></div>
	</section>
	<?php } else { ?>
		<div class="rem-leaflet-map-area" id="<?php echo esc_attr($map_id); ?>"></div>
	<?php } ?>
</div>