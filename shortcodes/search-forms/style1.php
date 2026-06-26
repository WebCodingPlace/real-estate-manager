<div class="search-container rem-search-1 fixed-map <?php echo ($auto_complete == 'enable') ? 'auto-complete' : '' ; ?>">
	<div class="search-options sample-page">
		<div class="searcher">
			<div class="row margin-div <?php echo ($disable_eq_height != 'yes') ? 'wcp-eq-height' : '' ; ?>">

				<?php do_action( 'rem_search_property_before_fields', $fields_arr, $columns ); ?>
				
				<?php if (in_array('search', $fields_arr)) { ?>
					<div class="col-sm-6 col-md-<?php echo esc_attr($columns); ?> margin-bottom">
						<input class="form-control" type="text" name="search_property" id="keywords" placeholder="<?php esc_attr_e( 'Keywords', 'real-estate-manager' ); ?>" />
					</div>
				<?php } else {
					echo '<input value="" type="hidden" name="search_property" />';
				} ?>
				
				<?php foreach ($default_fields as $field) {

					$show_condition = isset($field['show_condition']) ? $field['show_condition'] : 'true' ; 
					$conditions = isset($field['condition']) ? $field['condition'] : array() ;
					if (in_array($field['key'], $fields_arr) && 'property_price' != $field['key']){ ?>
						<div class="col-sm-6 col-md-<?php echo esc_attr($columns); ?> margin-bottom search-field" data-condition_status="<?php echo esc_attr($show_condition); ?>" data-condition_bound="<?php echo isset($field['condition_bound']) ? esc_attr($field['condition_bound']) : 'all' ?>" data-condition='<?php echo json_encode($conditions); ?>'>
							<span id="span-<?php echo esc_attr($field['key']); ?>" data-text="<?php echo rem_wpml_translate($field['title'], 'real-estate-manager-fields'); ?>"></span>
							<?php rem_render_property_search_fields($field, 'shortcode'); ?>
						</div>
					<?php }
				} ?>
				
				<?php foreach ($fields_arr as $key) { if( $key == 'order' || $key == 'tags' || $key == 'categories' || $key == 'orderby' || $key == 'agent'|| $key == 'property_id'){ ?>
						<div class="col-sm-6 col-md-<?php echo esc_attr($columns); ?> margin-bottom">
							<?php rem_render_special_search_fields($key); ?>
						</div>
				<?php }} ?>

				
				<?php if (in_array('property_price', $fields_arr)) { ?>
					<div class="p-slide-wrap col-sm-6 col-md-<?php echo esc_attr($columns) ?> margin-bottom">
						<?php rem_render_price_range_field('shortcode'); ?>
					</div>
				<?php } ?>

				<?php do_action( 'rem_search_property_after_fields', $fields_arr, $columns ); ?>

			</div>
			<div class="row filter hide-filter">
				<?php
					if ($more_filters_features == 'enable') {
						foreach ($property_individual_cbs as $cb) { ?>
						<div class="<?php echo esc_attr($more_filters_column_class); ?>">
							<?php
								$cb = stripcslashes($cb);
								$translated_text = rem_wpml_translate($cb, 'real-estate-manager-features');
							?>
							<input class="labelauty" type="checkbox" name="detail_cbs[<?php echo esc_attr($cb); ?>]" data-labelauty="<?php echo esc_attr($translated_text); ?>">
						</div>
					<?php
						}
					}

					if ($fields_to_hide != '' && !empty($filter_fields_arr)) {
						foreach ($default_fields as $field) {

							$show_condition = isset($field['show_condition']) ? $field['show_condition'] : 'true' ; 
							$conditions = isset($field['condition']) ? $field['condition'] : array() ;
							if (in_array($field['key'], $filter_fields_arr) && 'property_price' != $field['key']){ ?>
								<div class="col-sm-6 col-md-<?php echo esc_attr($more_filters_column_class); ?> margin-bottom search-field" data-condition_status="<?php echo esc_attr($show_condition); ?>" data-condition_bound="<?php echo isset($field['condition_bound']) ? esc_attr($field['condition_bound']) : 'all' ?>" data-condition='<?php echo json_encode($conditions); ?>'>
									<span id="span-<?php echo esc_attr($field['key']); ?>" data-text="<?php echo rem_wpml_translate($field['title'], 'real-estate-manager-fields'); ?>"></span>
									<?php rem_render_property_search_fields($field, 'shortcode'); ?>
								</div>
							<?php }
						}

						foreach ($filter_fields_arr as $key) { if( $key == 'order' || $key == 'tags' || $key == 'categories' || $key == 'orderby' || $key == 'agent'|| $key == 'property_id'){ ?>
								<div class="col-sm-6 col-md-<?php echo esc_attr($more_filters_column_class); ?> margin-bottom">
									<?php rem_render_special_search_fields($key); ?>
								</div>
						<?php }}
					}
				?>
			</div><!-- ./filter -->
			<div class="margin-div footer">
				<?php if ($filters_btn_text != '') { ?>
					<button type="button" class="btn btn-default more-button">
						<?php echo esc_attr($filters_btn_text); ?>
					</button>
				<?php } ?>
				<?php if ($reset_btn_text != '') { ?>
					<button type="reset" class="btn btn-default">
						<?php echo esc_attr($reset_btn_text); ?>
					</button>
				<?php } ?>
				<button type="submit" class="btn btn-default search-button">
					<?php echo esc_attr($search_btn_text); ?>
				</button>
				<?php do_action( 'rem_search_form_after_buttons' ); ?>
			</div><!-- ./footer -->
		</div><!-- ./searcher -->
	</div><!-- search-options -->
</div><!-- search-container fixed-map -->