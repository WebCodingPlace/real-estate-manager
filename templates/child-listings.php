<div class="child-listings-wrap">
	<?php
		$fields = rem_get_option('child_listing_fields');
		if ($fields != '') {
			$field_keys = array_map('trim', explode("\n", $fields));
		} else {
			$field_keys = array('property_area', 'property_status', 'property_price');
		}
		
		foreach ( $child_listings as $child_id ) { ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo get_the_title( $child_id ); ?>
					<div class="child-fields-wrap">
						<?php
							foreach ($field_keys as $field_key) {
								$value = rem_get_field_value($field_key, $child_id);
								if ($value) { ?>
									<span class="badge"><?php echo esc_attr($value); ?></span>
								<?php }
							}
						?>
					</div>
				</div>
				<div class="panel-body rem-child-listing-content">
					<?php echo get_the_post_thumbnail( $child_id, 'full' ); ?>
					<p><?php echo get_the_excerpt( $child_id ); ?></p>
					<p class="text-center">
						<br>
						<a href="<?php echo get_permalink( $child_id ); ?>" class="btn btn-primary">
							<?php esc_attr_e( 'More Details', 'real-estate-manager' ); ?>
						</a>
					</p>
				</div>
			</div>
		<?php }
	?>
</div>