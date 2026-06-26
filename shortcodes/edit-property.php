<?php
$property_id = esc_attr( $_GET['property_id'] );
$property_data = get_post( $property_id );
$p_tags = wp_get_post_terms( $property_id ,'rem_property_tag' );
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
								<input value="<?php echo esc_attr($property_data->post_title); ?>" id="title" class="form-control" type="text" required placeholder="<?php esc_attr_e( 'Property Title', 'real-estate-manager' ); ?>" name="title">
							</div>
							<div class="col-md-12">
								<?php wp_editor( $property_data->post_content, 'rem-content', array(
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
							<h3 class="title"><?php esc_attr_e( 'Images', 'real-estate-manager' ); ?></h3>
						</div>
						<p class="text-center">
							<button class="btn btn-default upload_image_button">
								<span class="dashicons dashicons-images-alt2"></span>
								<?php esc_attr_e( 'Click here to Upload Images', 'real-estate-manager' ); ?>
							</button>
						</p>
						<p>
							<?php echo nl2br(rem_get_option('upload_images_inst')); ?>
						</p>
							<?php 
								$images_ids = get_post_meta( $property_id, 'rem_property_images', true );
							?>
							<div class="row thumbs-prev">
								<?php if ($images_ids != '') {
									foreach ($images_ids as $id) {
										$image_url = wp_get_attachment_image_src( $id, 'thumbnail' ); ?>
										<div class="col-sm-3">
											<div class="rem-preview-image">
												<input type="hidden" name="rem_property_data[property_images][<?php echo esc_attr($id); ?>]" value="<?php echo esc_attr($id); ?>">
												<div class="rem-image-wrap" data-media-type="<?php echo wp_attachment_is( 'video', $id ) ? "video" : "image" ?>">
													<?php if (wp_attachment_is( 'video', $id )) { ?>
														<img src="<?php echo REM_URL . '/assets/images/video.png'; ?>">
													<?php } else { ?>
														<img src="<?php echo esc_url($image_url[0]); ?>">													
													<?php } ?>
												</div>
												<div class="rem-actions-wrap">
													<a target="_blank" href="<?php echo admin_url( 'post.php' ); ?>?post=<?php echo esc_attr($id); ?>&action=edit&image-editor&rem_image_editor" class="btn btn-info btn-sm">
														<i class="fa fa-crop"></i>
													</a>
													<a href="javascript:void(0)" class="btn remove-image btn-sm">
														<i class="fa fa-times"></i>
													</a>
												</div>
											</div>
										</div>
									<?php }
								} ?>
							</div>
						<div style="clear: both; display: block;"></div>						
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
											if($field['tab'] == $name && rem_is_field_accessible($field, $property_id)){
												if($field['tab'] == $name){
													if ($name == 'property_details') {
														$p_cbs = get_post_meta( $property_id, 'rem_property_detail_cbs', true );
														$this->render_property_field($field, $p_cbs);
													} else {
														$value = get_post_meta( $property_id, 'rem_'.$field['key'], true );
														$this->render_property_field($field, $value);
													}
												}
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
								<textarea class="form-control" name="tags"><?php
									foreach ($p_tags as $tag) {
										echo esc_attr($tag->name).',';
									}
								?></textarea>
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
					<?php do_action( 'rem_edit_property_before_submit', esc_attr( $property_id ) ); ?>
					<br>
					<div class="row">
						<?php if (get_post_status( $property_id ) != 'pending') { ?>
						<div class="col-sm-6 col-md-4">
							<select name="accessibility" class="form-control">
								<option value=""> -- <?php esc_attr_e( 'Accessibility', 'real-estate-manager' ); ?> -- </option>
								<option <?php echo (get_post_status($property_id) == 'draft') ? 'selected' : '' ; ?> value="draft"><?php esc_attr_e( 'Draft', 'real-estate-manager' ); ?></option>
								<option <?php echo (get_post_status($property_id) == 'publish') ? 'selected' : '' ; ?> value="publish"><?php esc_attr_e( 'Publish', 'real-estate-manager' ); ?></option>
							</select>
						</div>
						<?php } else { ?>
							<div class="col-sm-12 col-md-12">
								<div class="alert alert-info badge"><?php echo esc_attr( $waiting_message ); ?></div>
							</div>
						<?php } ?>
						<div class="col-sm-6 col-md-4">
							<input type="hidden" name="property_id" value="<?php echo esc_attr( $property_id ); ?>">
							<input class="btn btn-default" type="submit" value="<?php esc_attr_e( 'Save Changes', 'real-estate-manager' ); ?>">
						</div>
					</div>
					<br>
					<br>
					<div class="alert with-icon alert-info creating-prop" style="display:none;" role="alert">
						<i class="icon fa fa-info"></i>
						<span class="msg"><?php esc_attr_e( 'Please wait! your porperty is being modified...', 'real-estate-manager' ); ?></span>
					</div>
				</div>
			</div>
	</form>
</section>
</div>