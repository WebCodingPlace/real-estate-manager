<hr>
<?php $agent_fields = $this->get_agent_fields(); ?>
<h3><?php _e( 'Agent Details', 'real-estate-manager' ); ?></h3>

<table class="form-table">
    <?php foreach ($agent_fields as $field) { if (isset($field['display']) && in_array('admin', $field['display'])) { ?>
        
        <tr>
            <th>
                <label for="<?php echo $field['key']; ?>">
                    <?php echo $field['title']; ?>
                </label>
            </th>
            <td>

                <?php switch ($field['type']) {

                    case 'image': ?>
                        <span class="rem-image-wrap">
                            <?php if (get_the_author_meta( $field['key'], $user->ID ) != '') { ?>
                                <img style="max-width: 150px;" src="<?php echo esc_url_raw( get_the_author_meta( $field['key'], $user->ID ) ); ?>">
                            <?php } ?>
                        </span>
                        <br>
                        <input type="text" name="<?php echo $field['key']; ?>" id="<?php echo $field['key']; ?>" value="<?php echo esc_url_raw( get_the_author_meta( $field['key'], $user->ID ) ); ?>" class="img-url regular-text" />
                        <input type='button' class="upload_image_agent button-primary" value="<?php _e( 'Upload Image', 'real-estate-manager' ); ?>"/><br />
                        
                    <?php break;

                    case 'text': ?>
                        <input type="text" name="<?php echo $field['key']; ?>" value="<?php echo esc_attr(get_the_author_meta( $field['key'], $user->ID )); ?>" class="regular-text" />
                        
                    <?php break;

                    case 'textarea': ?>
                        <textarea name="<?php echo $field['key']; ?>" id="<?php echo $field['key']; ?>" class="widefat" rows="5"><?php echo esc_attr(get_the_author_meta( $field['key'], $user->ID )); ?></textarea>
                        
                    <?php break;
                    
                    default: ?>
                        <input type="text" name="<?php echo $field['key']; ?>" value="<?php echo esc_attr(get_the_author_meta( $field['key'], $user->ID )); ?>" class="regular-text" />
                        
                    <?php break;
                } ?>
                <p class="description"><?php echo (isset($field['help'])) ? $field['help'] : ''; ?></p>
            </td>
        </tr>
    <?php } } ?>
</table>
<hr>