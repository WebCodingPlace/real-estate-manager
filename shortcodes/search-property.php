<?php
	// geting data from rem class
	global $rem_ob;
	$default_fields = $rem_ob->single_property_fields();

	$fields_arr =  explode(',', $fields_to_show );

	$property_individual_cbs = $rem_ob->get_all_property_features();
?>
<div class="ich-settings-main-wrap">
<section id="rem-search-box" class="no-margin search-property-page">
	<form data-resselector="<?php echo $results_selector; ?>" class="<?php echo ($results_page != '') ? '' : 'search-property-form' ; ?>" action="<?php echo $results_page; ?>" method="get" id="search-property" data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>">
		<?php
			if ($fixed_fields != '') {
				$fixed_va_arr = explode(",", $fixed_fields);
				foreach ($fixed_va_arr as $fixed_va) {
					$fixed_data = explode("|", $fixed_va);
					echo '<input type="hidden" name="'.$fixed_data[0].'" value="'.$fixed_data[1].'">';
				}
			}
			if ($agent_id != '') {
					echo '<input type="hidden" name="agent_id" value="'.$agent_id.'">';
			}
			if ($order != '') {
					echo '<input type="hidden" name="order" value="'.$order.'">';
			}
			if ($orderby != '') {
					echo '<input type="hidden" name="orderby" value="'.$orderby.'">';
			}
		?>
		<input type="hidden" name="action" value="rem_search_property">
		<div class="search-container fixed-map">
			<div class="search-options sample-page">
				<div class="searcher">
					<div class="row margin-div <?php echo ($disable_eq_height != 'yes') ? 'wcp-eq-height' : '' ; ?>">
						
						<?php if (in_array('search', $fields_arr)) { ?>
							<div class="col-sm-6 col-md-<?php echo $columns; ?> margin-bottom">
								<input class="form-control" type="text" name="search_property" id="keywords" placeholder="<?php _e( 'Keywords', 'real-estate-manager' ); ?>" />
							</div>
						<?php } else {
							echo '<input value="" type="hidden" name="search_property" />';
						} ?>

						<?php foreach ($default_fields as $field) {
							if (in_array($field['key'], $fields_arr) && 'property_price' != $field['key']){ ?>
								<div class="col-sm-6 col-md-<?php echo $columns; ?> margin-bottom">
									<span id="span-<?php echo $field['key']; ?>" data-text="<?php echo $field['title']; ?>"></span>
									<?php rem_render_property_search_fields($field, 'shortcode'); ?>
								</div>
							<?php }
						} ?>
						
						<?php foreach ($fields_arr as $key) { if($key == 'order' || $key == 'orderby' || $key == 'agent'|| $key == 'property_id'){ ?>
								<div class="col-sm-6 col-md-<?php echo $columns; ?> margin-bottom">
									<?php rem_render_special_search_fields($key); ?>
								</div>
						<?php }} ?>

						
						<?php if (in_array('property_price', $fields_arr)) { ?>
							<div class="p-slide-wrap col-sm-6 col-md-<?php echo $columns ?> margin-bottom">
								<?php rem_render_price_range_field('shortcode'); ?>
							</div>
						<?php } ?>

					</div>
					<div class="row filter hide-filter hidden-xs hidden-sm">
						<?php foreach ($property_individual_cbs as $cb) { ?>
								<div class="<?php echo $more_filters_column_class; ?>">
									<input class="labelauty" type="checkbox" name="detail_cbs[<?php echo $cb; ?>]" data-labelauty="<?php echo stripcslashes($cb); ?>">
								</div>
						<?php } ?>
					</div><!-- ./filter -->
					<div class="margin-div footer">
						<?php if ($filters_btn_text != '') { ?>
							<button type="button" class="btn btn-default more-button hidden-xs hidden-sm">
								<?php echo $filters_btn_text; ?>
							</button>
						<?php } ?>
						<?php if ($reset_btn_text != '') { ?>
							<button type="reset" class="btn btn-default">
								<?php echo $reset_btn_text; ?>
							</button>
						<?php } ?>
						<button type="submit" class="btn btn-default search-button">
							<?php echo $search_btn_text; ?>
						</button>
					</div><!-- ./footer -->
				</div><!-- ./searcher -->
			</div><!-- search-options -->
		</div><!-- search-container fixed-map -->
	</form>
</section>


<section id="grid-content" class="search-results">
	<div class="loader text-center margin-bottom" style="display:none;margin-top:20px;">
		<img src="<?php echo REM_URL.'/assets/images/ajax-loader.gif'; ?>" alt="<?php _e( 'Loading...', 'real-estate-manager' ); ?>">
	</div>
	<div class="searched-proerpties">
		<?php echo apply_filters( 'the_content', $content ); ?>
	</div>
</section>
</div>