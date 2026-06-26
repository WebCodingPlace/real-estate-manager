 <tr class="form-field term-group-wrap">
   <th scope="row">
     <label for="category-image-id"><?php esc_attr_e( 'Thumbnail', 'real-estate-manager' ); ?></label>
   </th>
   <td>
     <?php $image_id = get_term_meta ( $term->term_id, 'category-image-id', true ); ?>
     <input type="hidden" id="category-image-id" name="category_image_id" value="<?php echo esc_attr($image_id); ?>">
      <input type="hidden" name="rem_nonce_edit_category_img" value="<?php echo wp_create_nonce('rem-nonce-edit-category-img'); ?>">
     <div id="category-image-wrapper">
       <?php if ( $image_id ) { ?>
         <?php echo wp_get_attachment_image ( $image_id, 'thumbnail' ); ?>
       <?php } ?>
     </div>
     <p>
       <input type="button" class="button button-secondary rem_tax_media_button" id="rem_tax_media_button" name="rem_tax_media_button" value="<?php esc_attr_e( 'Add Image', 'real-estate-manager' ); ?>" />
       <input type="button" class="button button-secondary rem_tax_media_remove" id="rem_tax_media_remove" name="rem_tax_media_remove" value="<?php esc_attr_e( 'Remove Image', 'real-estate-manager' ); ?>" />
     </p>
   </td>
 </tr>