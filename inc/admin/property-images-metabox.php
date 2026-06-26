<div class="ich-settings-main-wrap">
	<button class="button-secondary upload_image_button" data-title="<?php esc_attr_e( 'Select images for property gallery', 'real-estate-manager' ); ?>" data-btntext="<?php esc_attr_e( 'Insert', 'real-estate-manager' ); ?>">
		<span class="dashicons dashicons-images-alt2"></span>
		<?php esc_attr_e( 'Upload Images', 'real-estate-manager' ); ?>
	</button>
	<p><?php echo nl2br(rem_get_option('upload_images_inst')); ?></p>
	<?php global $post; 
	$images_ids = get_post_meta( $post->ID, 'rem_property_images', true );
	?>
	<div class="row thumbs-prev">
		<?php if ($images_ids != '') {
			foreach ($images_ids as $id) {
				$image_url = wp_get_attachment_image_src( $id, 'thumbnail' );
				?>
					<div class="col-sm-3">
						<div class="rem-preview-image">
							<input type="hidden" name="rem_property_data[property_images][<?php echo esc_attr($id); ?>]" value="<?php echo esc_attr($id); ?>">
							<div class="rem-image-wrap">
								<?php if (wp_attachment_is( 'video', $id )) { ?>
									<img src="<?php echo REM_URL . '/assets/images/video.png'; ?>">
								<?php } else { ?>
									<img src="<?php echo esc_url($image_url[0]); ?>">
								<?php } ?>
							</div>
							<div class="rem-actions-wrap">
								<a target="_blank" href="<?php echo admin_url( 'post.php' ); ?>?post=<?php echo esc_attr($id); ?>&action=edit&image-editor&rem_image_editor&nonce=<?php echo wp_create_nonce('rem-nonce-edit-img'); ?>" class="btn btn-info btn-sm">
									<i class="fa fa-crop"></i>
								</a>
								<a href="javascript:void(0)" class="btn remove-image btn-sm">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
					</div>
				<?php
			}
		} ?>
	</div>
	<div style="clear: both; display: block;"></div>
</div>