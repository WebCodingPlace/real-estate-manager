<div class="form-field term-group">
    <label for="category-image-id"><?php esc_attr_e('Thumbnail', 'real-estate-manager'); ?></label>
    <input type="hidden" id="category-image-id" name="category_image_id" class="custom_media_url" value="">
    <input type="hidden" name="rem_nonce_add_category_img" value="<?php echo wp_create_nonce('rem-nonce-add-category-img'); ?>">
    <div id="category-image-wrapper"></div>
    <p>
        <input type="button" class="button button-secondary rem_tax_media_button" id="rem_tax_media_button" name="rem_tax_media_button" value="<?php esc_attr_e( 'Add Image', 'real-estate-manager' ); ?>" />
        <input type="button" class="button button-secondary rem_tax_media_remove" id="rem_tax_media_remove" name="rem_tax_media_remove" value="<?php esc_attr_e( 'Remove Image', 'real-estate-manager' ); ?>" />
    </p>
</div>