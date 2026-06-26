<?php
    wp_enqueue_script( 'imgareaselect', get_bloginfo('url') . '/wp-includes/js/imgareaselect/jquery.imgareaselect.js', array( 'jquery' ), '1', true );
    wp_enqueue_style( 'imgareaselect', get_bloginfo('url') . '/wp-includes/js/imgareaselect/imgareaselect.css', array(), '0.9.8' );
?>	
<div class="ich-settings-main-wrap">
<section id="new-property">
	<form id="create-property" data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>">
		<input type="hidden" name="action" value="rem_create_pro_ajax">
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<div class="info-block" id="basic">
						<div class="section-title line-style no-margin">
							<h3 class="title"><?php esc_attr_e( 'Basic Information', 'real-estate-manager' ); ?></h3>
						</div>
						<div class="row">
							<div class="col-md-12 space-form">
								<input id="title" class="form-control" type="text" required placeholder="<?php esc_attr_e( 'Property Title', 'real-estate-manager' ); ?>" name="title">
							</div>
							<div class="col-md-12">
								<?php wp_editor( __( 'Property Description', 'real-estate-manager' ), 'rem-content', array(
									'quicktags' => array( 'buttons' => 'strong,em,del,ul,ol,li,close' ),
									'textarea_name' => 'content',
									'editor_height' => 350
								) ); ?>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>

					<div class="info-block" id="images">
						<div class="section-title line-style">
							<h3 class="title"><?php esc_attr_e( 'Images or Videos', 'real-estate-manager' ); ?></h3>
						</div>
						<p class="text-center">
							<button type="button" class="btn btn-default upload_image_button" data-title="<?php esc_attr_e( 'Select images for property gallery', 'real-estate-manager' ); ?>" data-btntext="<?php esc_attr_e( 'Insert', 'real-estate-manager' ); ?>">
								<span class="dashicons dashicons-images-alt2"></span>
								<?php esc_attr_e( 'Upload Images or Videos', 'real-estate-manager' ); ?>
							</button>
						</p>
						<p>
							<?php echo nl2br(rem_get_option('upload_images_inst')); ?>
						</p>
						<div class="row thumbs-prev">

						</div>						
					</div>
	
					<?php
						global $rem_ob;
						$inputFields = $rem_ob->get_all_property_fields();
						$tabsData = rem_get_single_property_settings_tabs();
				        $valid_tabs = array();
				        foreach ($tabsData as $tabData) {
				        	$tab_key = $tabData['key'];
				        	$tab_title = $tabData['title'];
				            foreach ($inputFields as $field) {
				                $field_tab = (isset($field['tab'])) ? $field['tab'] : '' ;
				                if ($tab_key == $field_tab && !in_array($field_tab, $valid_tabs)) {
				                   $valid_tabs[] = $field_tab; 
				                }
				            }
				        }
						foreach ($tabsData as $tabData) {
				        	$name = $tabData['key'];
				        	$title = $tabData['title'];
							if (in_array($name, $valid_tabs) && rem_is_tab_accessible($tabData)) { ?>
							<div class="info-block" id="<?php echo esc_attr($name); ?>">
								<div class="section-title line-style">
									<h3 class="title"><?php echo esc_attr($title); ?></h3>
								</div>

								<div class="row property-meta-fields <?php echo esc_attr($name); ?>-fields">
									<?php
										foreach ($inputFields as $field) {
											if($field['tab'] == $name && rem_is_field_accessible($field)){
												$this->render_property_field($field);
											}
										}
									?>
								</div>
							</div>
						<?php } 
						}
					?>

					<div class="info-block" id="tags">
						<div class="section-title line-style">
							<h3 class="title"><?php esc_attr_e( 'Tags', 'real-estate-manager' ); ?></h3>
						</div>
						<div class="row features-box">
							<div class="col-lg-12">
								<p><?php esc_attr_e( 'Each tag separated by comma', 'real-estate-manager' ); ?>  <code>,</code></p>
								<textarea class="form-control" name="tags"></textarea>
							</div>
						</div>
					</div>

					<div class="info-block" id="map">
						<div class="section-title line-style">
							<h3 class="title"><?php esc_attr_e( 'Place on Map', 'real-estate-manager' ); ?></h3>
						</div>
						<?php if (rem_get_option('use_map_from', 'leaflet') == 'google_maps') { ?>
							<input type="text" class="form-control" id="search-map" placeholder="<?php esc_attr_e( 'Type to Search...', 'real-estate-manager' ); ?>">
						<?php } ?>
						
						<div id="map-canvas" style="height: 300px"></div>

						<div id="position"><i class="fa fa-map-marker-alt"></i> <?php esc_attr_e( 'Drag the pin to the location on the map', 'real-estate-manager' ); ?></div>
					</div>
					<?php do_action( 'rem_create_property_before_submit' ); ?>
					<br>
					<input class="btn btn-default" id="form-submit" type="submit" value="<?php esc_attr_e( 'Create Property', 'real-estate-manager' ); ?>">
					<button class="btn btn-default" id="preview-property"><?php esc_attr_e( 'Preview', 'real-estate-manager' ); ?> </button>
					<?php do_action( 'rem_create_property_after_submit' ); ?>
					<br>
					<br>
					<div class="alert with-icon alert-info creating-prop" style="display:none;" role="alert">
						<i class="icon fa fa-info"></i>
						<span class="msg"><?php esc_attr_e( 'Please wait...', 'real-estate-manager' ); ?></span>
					</div>
				</div>
			</div>
	</form>
</section>
</div>