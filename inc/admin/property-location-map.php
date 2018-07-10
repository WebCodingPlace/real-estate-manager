<?php
global $post;
?>
<div class="ich-settings-main-wrap">
	<?php if (rem_get_option('use_map_from', 'leaflet') == 'google_maps') { ?>
	<input type="text" class="form-control" id="search-map" placeholder="<?php _e( 'Type to Search...', 'real-estate-manager' ); ?>">
	<?php } ?>
	<div id="map-canvas" style="height: 300px"></div>
	<br>
	<div id="position" class="alert alert-info">
		<?php
			_e( 'Search the address on search bar. ', 'real-estate-manager' );
			_e( 'Drag the pin to the location on the map', 'real-estate-manager' );
		?>
	</div>
</div>