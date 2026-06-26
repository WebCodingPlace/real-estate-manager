<?php
global $post;
?>
<div class="ich-settings-main-wrap">
	<?php if($post->post_parent){ ?>
		<br>
		<div class="alert alert-info">
			<?php esc_attr_e( 'This listing will take the location of its parent listing', 'real-estate-manager' ) ?>
			<a href="<?php echo get_permalink( $post->post_parent ) ?>"><b><?php echo get_the_title( $post->post_parent ); ?></b></a>
		</div>
	<?php } else { ?>
		<?php if (rem_get_option('use_map_from', 'leaflet') == 'google_maps') { ?>
		<input type="text" class="form-control" id="search-map" placeholder="<?php esc_attr_e( 'Type to Search...', 'real-estate-manager' ); ?>">
		<?php } ?>
		<div id="map-canvas" style="height: 300px"></div>
		<br>
		<div id="position" class="alert alert-info">
			<?php
				esc_attr_e( 'Search the address on search bar. ', 'real-estate-manager' );
				esc_attr_e( 'Drag the pin to the location on the map', 'real-estate-manager' );
			?>
		</div>
		<hr>
		<div class="checkbox">
			<?php $checked = (get_post_meta( $post->ID, '_disable_map', true ) == 'yes') ? 'checked' : '' ; ?>
			<label>
				<input <?php echo esc_attr($checked); ?> style="margin-top: 0;" type="checkbox" name="_disable_map"> <strong><?php esc_attr_e( 'Disable', 'real-estate-manager' ); ?></strong>
			</label>
			-
			<?php esc_attr_e( 'Checking this will disable map for this listing', 'real-estate-manager' ); ?>
		</div>
	<?php } ?>
</div>