<div class="search-container rem-search-2 fixed-map <?php echo ($auto_complete == 'enable') ? 'auto-complete' : '' ; ?>">
	<div class="search-options sample-page">
		<div class="searcher">
			<div class="row <?php echo ($disable_eq_height == '') ? 'wcp-eq-height' : '' ; ?>">

				<?php do_action( 'rem_search_property_before_fields', $fields_arr, $columns ); ?>
				
				<?php if (in_array('search', $fields_arr)) { ?>
					<div class="col-sm-6 col-md-<?php echo esc_attr($columns); ?> padding-none">
						<input class="form-control" type="text" name="search_property" id="keywords" placeholder="<?php esc_attr_e( 'Keywords', 'real-estate-manager' ); ?>" />
					</div>
				<?php } else {
					echo '<input value="" type="hidden" name="search_property" />';
				} ?>
				
				<?php foreach ($default_fields as $field) {

					$show_condition = isset($field['show_condition']) ? $field['show_condition'] : 'true' ; 
					$conditions = isset($field['condition']) ? $field['condition'] : array() ;
					if (in_array($field['key'], $fields_arr) && 'property_price' != $field['key']){ ?>
						<div class="col-sm-6 col-md-<?php echo esc_attr($columns); ?> padding-none search-field" data-condition_status="<?php echo esc_attr($show_condition); ?>" data-condition_bound="<?php echo isset($field['condition_bound']) ? esc_attr($field['condition_bound']) : 'all' ?>" data-condition='<?php echo json_encode($conditions); ?>'>
							<span id="span-<?php echo esc_attr($field['key']); ?>" data-text="<?php echo esc_attr($field['title']); ?>"></span>
							<?php rem_render_property_search_fields($field, 'shortcode'); ?>
						</div>
					<?php }
				} ?>
				
				<?php foreach ($fields_arr as $key) { if( $key == 'order' || $key == 'tags' || $key == 'categories' || $key == 'orderby' || $key == 'agent'|| $key == 'property_id'){ ?>
						<div class="col-sm-6 col-md-<?php echo esc_attr($columns); ?> padding-none">
							<?php rem_render_special_search_fields($key); ?>
						</div>
				<?php }} ?>

				
				<?php if (in_array('property_price', $fields_arr)) { ?>
					<div class="p-slide-wrap col-sm-6 col-md-<?php echo esc_attr($columns) ?> padding-none">
						<?php rem_render_price_range_field('shortcode'); ?>
					</div>
				<?php } ?>

				<?php do_action( 'rem_search_property_after_fields', $fields_arr, $columns ); ?>

				<div class="col-sm-6 col-md-<?php echo esc_attr($columns); ?> padding-none">
					<button type="submit" class="btn btn-default search-button">
						<?php echo esc_attr($search_btn_text); ?>
					</button>
					<?php do_action( 'rem_search_form_after_buttons' ); ?>
				</div>

			</div>
		</div><!-- ./searcher -->
	</div><!-- search-options -->
</div><!-- search-container fixed-map -->