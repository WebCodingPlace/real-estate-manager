<button class="button-secondary upload_image_button" data-title="<?php _e( 'Select images for property gallery', 'real-estate-manager' ); ?>" data-btntext="<?php _e( 'Insert', 'real-estate-manager' ); ?>">
	<span class="dashicons dashicons-images-alt2"></span>
	<?php _e( 'Upload Images', 'real-estate-manager' ); ?>
</button>
<br>
<br>
<?php global $post; 
$images_ids = get_post_meta( $post->ID, 'rem_property_images', true );
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