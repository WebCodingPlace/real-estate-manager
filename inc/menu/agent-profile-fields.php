<hr>
<?php $agent_fields = $this->get_agent_fields(); ?>
<h3><?php esc_attr_e( 'Agent Details', 'real-estate-manager' ); ?></h3>
<?php wp_nonce_field( 'rem_save_agent_fields', 'rem_agent_fields_nonce' ); ?>
<table class="form-table">
    <?php foreach ($agent_fields as $field) { if (isset($field['display']) && in_array('admin', $field['display'])) { ?>
        
        <tr>
            <th>
                <label for="<?php echo esc_attr($field['key']); ?>">
                    <?php echo esc_attr($field['title']); ?>
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
                        <input type="text" name="<?php echo esc_attr($field['key']); ?>" id="<?php echo esc_attr($field['key']); ?>" value="<?php echo esc_url_raw( get_the_author_meta( $field['key'], $user->ID ) ); ?>" class="img-url regular-text" />
                        <input type='button' class="upload_image_agent button-primary" value="<?php esc_attr_e( 'Upload Image', 'real-estate-manager' ); ?>"/><br />
                        
                    <?php break;

                    case 'text': ?>
                        <input type="text" name="<?php echo esc_attr($field['key']); ?>" value="<?php echo esc_attr(get_the_author_meta( $field['key'], $user->ID )); ?>" class="regular-text" />
                        
                    <?php break;

                    case 'select': ?>
                    <select name="<?php echo esc_attr($field['key']); ?>" <?php echo (isset($field['required']) && $field['required'] == 'true') ? 'required' : '' ; ?>>
                        <?php
                        $options = explode("\n", $field['options']);
                        $val = get_user_meta( $user->ID, $field['key'], true );
                        $val = trim($val);
                        foreach ($options as $op) {
                            $op = trim($op);
                            echo '<option '.selected( $val, $op ).' value="'.esc_attr($op).'">'.esc_attr($op).'</option>';
                        } ?>
                    </select>                      
                        
                    <?php break;

                    case 'textarea': ?>
                        <textarea name="<?php echo esc_attr($field['key']); ?>" id="<?php echo esc_attr($field['key']); ?>" class="widefat" rows="5"><?php echo esc_attr(get_the_author_meta( $field['key'], $user->ID )); ?></textarea>
                        
                    <?php break;
                    
                    default: ?>
                        <input type="text" name="<?php echo esc_attr($field['key']); ?>" value="<?php echo esc_attr(get_the_author_meta( $field['key'], $user->ID )); ?>" class="regular-text" />
                        
                    <?php break;
                } ?>
                <p class="description"><?php echo (isset($field['help'])) ? esc_attr($field['help']) : ''; ?></p>
            </td>
        </tr>
    <?php } } ?>
</table>
<hr>