<div class="search-container rem-search-4 <?php echo ($auto_complete == 'enable') ? 'auto-complete' : '' ; ?>">

	<?php if (in_array($tabs_field, $fields_arr)) {
		$field_data = rem_get_field_data($tabs_field);
		$options = $field_data['options'];
	 ?>
		<ul id="rem-search-tab" class="rem-search-tab nav nav-pills">
				<li class="rem-search-tab-item active">
				    <a class="rem-search-tab-link" data-val="" href="#">
				        <?php echo esc_attr($tabs_all_text); ?>
				    </a>
				</li>		
	        <?php
	        	if (is_array($options)) {
	        		foreach ($options as $option) { ?>
					    <li class="rem-search-tab-item">
					        <a class="rem-search-tab-link" data-val="<?php echo esc_attr($option); ?>" href="#">
					            <?php echo rem_wpml_translate($option, 'real-estate-manager-fields') ?>
					        </a>
					    </li>
	        		<?php }
	        	}
	        ?>
		</ul>

		<input class="tab-field-hidd" type="hidden" name="<?php echo esc_attr($tabs_field); ?>" value="">
	<?php } ?>

	<div class="search-options sample-page">
		<div class="searcher">
			<div class="row">
				<div class="col-sm-9">
					<div class="row <?php echo ($disable_eq_height == '' || $disable_eq_height == 'enable') ? 'wcp-eq-height' : '' ; ?>">

						<?php do_action( 'rem_search_property_before_fields', $fields_arr, $columns ); ?>
						
						<?php if (in_array('search', $fields_arr)) { ?>
							<div class="col-sm-6 col-md-<?php echo esc_attr($columns); ?> padding-none margin-bottom">
								<label for="keywords"><?php esc_attr_e( 'Keywords', 'real-estate-manager' ); ?></label>
								<input class="form-control" type="text" name="search_property" id="keywords" />
							</div>
						<?php } else {
							echo '<input value="" type="hidden" name="search_property" />';
						} ?>
						
						<?php
						if (($selected_key = array_search($tabs_field, $fields_arr)) !== false) {
						    unset($fields_arr[$selected_key]);
						}

						foreach ($default_fields as $field) {

							$show_condition = isset($field['show_condition']) ? $field['show_condition'] : 'true' ; 
							$conditions = isset($field['condition']) ? $field['condition'] : array() ;
							if (in_array($field['key'], $fields_arr) && 'property_price' != $field['key']){ ?>
								<div class="col-sm-6 col-md-<?php echo esc_attr($columns); ?> padding-none margin-bottom search-field" data-condition_status="<?php echo esc_attr($show_condition); ?>" data-condition_bound="<?php echo isset($field['condition_bound']) ? esc_attr($field['condition_bound']) : 'all' ?>" data-condition='<?php echo json_encode($conditions); ?>'>
									<?php rem_render_property_search_fields($field, 'shortcode', true); ?>
								</div>
							<?php }
						} ?>
						
						<?php foreach ($fields_arr as $key) { if( $key == 'order' || $key == 'tags' || $key == 'categories' || $key == 'orderby' || $key == 'agent'|| $key == 'property_id'){ ?>
								<div class="col-sm-6 col-md-<?php echo esc_attr($columns); ?> padding-none margin-bottom">
									<?php rem_render_special_search_fields($key, true); ?>
								</div>
						<?php }} ?>

						
						<?php if (in_array('property_price', $fields_arr)) { ?>
							<div class="p-slide-wrap col-sm-6 col-md-<?php echo esc_attr($columns) ?> padding-none margin-bottom">
								<?php rem_render_price_range_field('shortcode', true); ?>
							</div>
						<?php } ?>

						<?php do_action( 'rem_search_property_after_fields', $fields_arr, $columns ); ?>

					</div>
				</div>
				<div class="col-sm-3 search-btn-outer-wrap">
					<div class="search-btn-inner-wrap">
						<button type="submit" class="btn btn-default btn-block search-button">
							<span class="glyphicon glyphicon-search"></span>
							<?php echo esc_attr($search_btn_text); ?>
						</button>
						<?php do_action( 'rem_search_form_after_buttons' ); ?>
					</div>
				</div>
				<div class="row toggle-filters">
					<div class="col-sm-12">
						<?php if ($filters_btn_text != '') { ?>
							<p class="more-button">
								<span class="glyphicon glyphicon-plus"></span>
								<?php echo esc_attr($filters_btn_text); ?>
							</p>
						<?php } ?>
					</div>
				</div>
				<div class="row filter hide-filter">
					<?php foreach ($property_individual_cbs as $cb) { ?>
						<div class="<?php echo esc_attr($more_filters_column_class); ?>">
							<?php
								$cb = stripcslashes($cb);
								$translated_text = rem_wpml_translate($cb, 'real-estate-manager-features');
							?>
							<input class="labelauty" type="checkbox" name="detail_cbs[<?php echo esc_attr($cb); ?>]" data-labelauty="<?php echo esc_attr($translated_text); ?>">
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<style type="text/css">
	.rem-search-4 .search-options {
		background-color: #FFF;
		border-radius: 10px;
		border-top-left-radius: 0;
		padding: 10px 20px;
	}
	.rem-search-4 .search-btn-outer-wrap {
		display: table;
	}
	.rem-search-4 .search-btn-inner-wrap {
		display: table-cell;
		vertical-align: middle;
	}
	.rem-search-4 .nice-select, .rem-search-4 select {
		background: transparent !important;
		border: none !important;
		padding: 0 !important;
		box-shadow: none !important;
	}
	.toggle-filters {
		padding: 10px 20px;
	}
	.toggle-filters p {
		margin: 0;
		padding: 0;
		cursor: pointer;
	}
	.rem-search-4 .search-btn-inner-wrap button {
		padding: 15px;
		border-radius: 5px !important;
	}
	.rem-search-4 .filter {
		padding: 0 20px !important;
	}
	#rem-search-tab li a {
		border-radius: 0;
	}
	#rem-search-tab li {
		margin: 0;
	}
	#rem-search-tab li {
		background-color: #FFF;
	}
	#rem-search-tab li {
		background-color: #FFF;
	}
	#rem-search-tab li:first-child a, #rem-search-tab li:first-child {
		border-top-left-radius: 5px;
	}
	#rem-search-tab li:last-child a, #rem-search-tab li:last-child {
		border-top-right-radius: 5px;
	}
</style>

<script type="text/javascript">
	jQuery(function($) {
        $('#rem-search-tab').on('click', 'a', function(e){
        	e.preventDefault();

        	$('#rem-search-tab li').removeClass('active');
        	$(this).closest('li').addClass('active');

        	var active_value = $(this).attr('data-val');
        	$(this).closest('.rem-search-4').find('.tab-field-hidd').val(active_value).change();
        });
    });
</script>