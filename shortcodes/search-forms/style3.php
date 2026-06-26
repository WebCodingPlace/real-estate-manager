<div class="search-container rem-search-3 fixed-map <?php echo ($auto_complete == 'enable') ? 'auto-complete' : '' ; ?>">

	<?php if (in_array($tabs_field, $fields_arr)) {
		$field_data = rem_get_field_data($tabs_field);
		$options = $field_data['options'];
	 ?>
		<ul id="rem-search-tab" class="rem-search-tab justify-content-center">
				<li class="rem-search-tab-item">
				    <a class="rem-search-tab-link active-tab" data-val="" href="#">
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
		<input type="hidden" class="tab-field-hidd" name="<?php echo esc_attr($tabs_field); ?>" value="">
	<?php } ?>

	<div class="search-options sample-page">
		<div class="searcher">
			<div class="row <?php echo ($disable_eq_height == '' || $disable_eq_height == 'enable') ? 'wcp-eq-height' : '' ; ?>">

				<?php do_action( 'rem_search_property_before_fields', $fields_arr, $columns ); ?>
				
				<?php if (in_array('search', $fields_arr)) { ?>
					<div class="col-sm-6 col-md-<?php echo esc_attr($columns); ?> padding-none margin-bottom">
						<input class="form-control" type="text" name="search_property" id="keywords" placeholder="<?php esc_attr_e( 'Keywords', 'real-estate-manager' ); ?>" />
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
							<span id="span-<?php echo esc_attr($field['key']); ?>" data-text="<?php echo esc_attr($field['title']); ?>"></span>
							<?php rem_render_property_search_fields($field, 'shortcode'); ?>
						</div>
					<?php }
				} ?>
				
				<?php foreach ($fields_arr as $key) { if( $key == 'order' || $key == 'tags' || $key == 'categories' || $key == 'orderby' || $key == 'agent'|| $key == 'property_id'){ ?>
						<div class="col-sm-6 col-md-<?php echo esc_attr($columns); ?> padding-none margin-bottom">
							<?php rem_render_special_search_fields($key); ?>
						</div>
				<?php }} ?>

				
				<?php if (in_array('property_price', $fields_arr)) { ?>
					<div class="p-slide-wrap col-sm-6 col-md-<?php echo esc_attr($columns) ?> padding-none margin-bottom">
						<?php rem_render_price_range_field('shortcode'); ?>
					</div>
				<?php } ?>

				<?php do_action( 'rem_search_property_after_fields', $fields_arr, $columns ); ?>

				<div class="col-sm-6 col-md-<?php echo esc_attr($columns); ?> padding-none margin-bottom">
					<button type="submit" class="btn btn-default btn-block search-button">
						<?php echo esc_attr($search_btn_text); ?>
					</button>
					<?php do_action( 'rem_search_form_after_buttons' ); ?>
				</div>

			</div>
		</div>
	</div>
</div>

<style type="text/css">
	.justify-content-center {
	    -ms-flex-pack: center!important;
	    justify-content: center!important;
	}
	ul.rem-search-tab{
		display: -ms-flexbox;
	    display: flex;
	    -ms-flex-wrap: wrap;
	    flex-wrap: wrap;
	    padding: 0 !important;
	    margin-bottom: 7px !important;
	    list-style: none !important;
	}
	ul.rem-search-tab li a{
		color: #fff;
	    font-weight: 600;
	    margin: 0 2px 0 0;
	    border-radius: 4px 4px 0 0;
	    padding: 12px 20px;
	}	
	.rem-search-tab-link {
	    padding: 10px 21px 10px 25px !important;
	    margin: 0px 1px 0px 1px !important;
	    text-decoration: none !important;
	    color: #ffffff !important;
	    background-color: rgba(0, 174, 255, 0.56) !important;	    
	}
	.rem-search-tab-item a.active-tab {
	    color: #000000 !important;
	    background-color: #ffffff !important;
		border: 1px solid #eceff1;
		border-bottom: 0;	    
	}
	.rem-search-3 .search-options.sample-page{
		background-color: #FFFFFF;
    	padding: 30px 30px 10px 30px;
    	border-radius: 4px 4px 4px 4px;
    	box-shadow: 0px 20px 40px 0px rgba(0, 0, 0, 0.1);
	}
	.margin-bottom .btn-block {
		height: 35px;
	}
</style>

<script type="text/javascript">
	jQuery(function($) {

        $('#rem-search-tab').on('click', 'a', function(e){
        	e.preventDefault();

        	$('#rem-search-tab li a').removeClass('active-tab');
        	$(this).addClass('active-tab');

        	var active_value = $(this).attr('data-val');
        	$(this).closest('.rem-search-3').find('.tab-field-hidd').val(active_value).change();
        });
    });
</script>