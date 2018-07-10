<?php
$property_data = get_post( $_GET['property_id'] );
$p_tags = wp_get_post_terms( $_GET['property_id'] ,'rem_property_tag' );
// var_dump();
?>
<div class="ich-settings-main-wrap">
<section id="new-property">
	<form id="create-property" data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>">
		<input type="hidden" name="action" value="rem_create_pro_ajax">
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<div class="info-block" id="basic">
						<div class="section-title line-style no-margin">
							<h3 class="title"><?php _e( 'Basic Information', 'real-estate-manager' ); ?></h3>
						</div>
						<div class="row">
							<div class="col-md-12 space-form">
								<input value="<?php echo $property_data->post_title; ?>" id="title" class="form-control" type="text" required placeholder="<?php _e( 'Property Title', 'real-estate-manager' ); ?>" name="title">
							</div>
							<div class="col-md-12">
								<?php wp_editor( $property_data->post_content, 'rem-content', array('textarea_name' => 'content', 'editor_height' => 350 ) ); ?>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
					
					<div class="info-block" id="images">
						<div class="section-title line-style">
							<h3 class="title"><?php _e( 'Images', 'real-estate-manager' ); ?></h3>
						</div>
						<p style="text-align: center">
							<button class="btn btn-default upload_image_button">
								<span class="dashicons dashicons-images-alt2"></span>
								<?php _e( 'Click here to Upload Images', 'real-estate-manager' ); ?>
							</button>
						</p>
						<br>
						<br>
							<?php 
								$images_ids = get_post_meta( $_GET['property_id'], 'rem_property_images', true );
							?>
							<div class="thumbs-prev">
								<?php if ($images_ids != '') {
									foreach ($images_ids as $id) {
										$image_url = wp_get_attachment_image_src( $id, 'thumbnail' );
										// var_dump($image_url);
										// $image_url = wp_get_attachment_url( $id );
										echo '<div><input type="hidden" name="rem_property_data[property_images]['.$id.']" value="'.$id.'"><img src="'.$image_url[0].'"><span class="dashicons dashicons-dismiss"></span></div>';
									}
								} ?>
							</div>
						<div style="clear: both; display: block;"></div>						
					</div>

					<?php
						global $rem_ob;
						$inputFields = $rem_ob->get_all_property_fields();
						$tabsData = rem_get_single_property_settings_tabs();
						foreach ($tabsData as $name => $title) { ?>
							<div class="info-block" id="<?php echo $name; ?>">
								<div class="section-title line-style">
									<h3 class="title"><?php echo $title; ?></h3>
								</div>

								<div class="row property-meta-fields <?php echo $name; ?>-fields">
									<?php
										foreach ($inputFields as $field) {
											if($field['tab'] == $name){
												if ($name == 'property_details') {
													$p_cbs = get_post_meta( $_GET['property_id'], 'rem_property_detail_cbs', true );
													$this->render_property_field($field, $p_cbs);
												} else {
													$value = get_post_meta( $_GET['property_id'], 'rem_'.$field['key'], true );
													$this->render_property_field($field, $value);
												}
											}
										}
									?>
								</div>
							</div>
						<?php }
					?>

					<div class="info-block" id="tags">
						<div class="section-title line-style">
							<h3 class="title"><?php _e( 'Tags', 'real-estate-manager' ); ?></h3>
						</div>
						<div class="row features-box">
							<div class="col-lg-12">
								<p><?php _e( 'Each tag separated by comma', 'real-estate-manager' ); ?>  <code>,</code></p>
								<textarea class="form-control" name="tags"><?php
									foreach ($p_tags as $tag) {
										echo $tag->name.',';
									}
								?></textarea>
							</div>
						</div>
					</div>

					<div class="info-block" id="map">
						<div class="section-title line-style">
							<h3 class="title"><?php _e( 'Place on Map', 'real-estate-manager' ); ?></h3>
						</div>
						<?php if (rem_get_option('use_map_from', 'leaflet') == 'google_maps') { ?>
						<input type="text" class="form-control" id="search-map" placeholder="<?php _e( 'Type to Search...', 'real-estate-manager' ); ?>">
						<?php } ?>
						<div id="map-canvas" style="height: 300px"></div>

						<div id="position"><i class="fa fa-map-marker"></i> <?php _e( 'Drag the pin to the location on the map', 'real-estate-manager' ); ?></div>
					</div>
					<br>
					<input type="hidden" name="property_id" value="<?php echo $_GET['property_id']; ?>">
					<input class="btn btn-default" type="submit" value="<?php _e( 'Save Changes', 'real-estate-manager' ); ?>">
					<br>
					<br>
					<div class="alert with-icon alert-info creating-prop" style="display:none;" role="alert">
						<i class="icon fa fa-info"></i>
						<span class="msg"><?php _e( 'Please wait! your porperty is being modified...', 'real-estate-manager' ); ?></span>
					</div>
				</div>
			</div>
	</form>
</section>
</div>