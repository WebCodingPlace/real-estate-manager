<?php

	$saved_settings = get_option( 'rem_all_settings' );
    // var_dump($saved_settings);
    $default = (isset($field['default'])) ? $field['default'] : '' ;
    $field_value = (isset($saved_settings[$field['name']])) ? $saved_settings[$field['name']] : $default ;

    switch ($field['type']) {

        case 'text': ?>

            <div class="form-group wrap_<?php echo $field['name']; ?>">
                <label for="<?php echo $field['name']; ?>" class="col-sm-4 control-label"><?php echo $field['title']; ?></label>
                <div class="col-sm-8">
                    <input type="text" name="<?php echo $field['name']; ?>" class="form-control input-sm" id="<?php echo $field['name']; ?>" value="<?php echo $field_value; ?>">
                    <span class="help-block"><?php echo $field['help']; ?></span>
                </div>
            </div>
            <?php break;

        case 'color': ?>

            <div class="form-group wrap_<?php echo $field['name']; ?>">
                <label for="<?php echo $field['name']; ?>" class="col-sm-4 control-label"><?php echo $field['title']; ?></label>
                <div class="col-sm-8">
                    <input type="text" name="<?php echo $field['name']; ?>" class="form-control input-sm colorpicker" id="<?php echo $field['name']; ?>" value="<?php echo $field_value; ?>">
                    <span class="help-block"><?php echo $field['help']; ?></span>
                </div>
            </div>
            <?php break;

        case 'number': ?>

            <div class="form-group wrap_<?php echo $field['name']; ?>">
                <label for="<?php echo $field['name']; ?>" class="col-sm-4 control-label"><?php echo $field['title']; ?></label>
                <div class="col-sm-8">
                    <input type="number" name="<?php echo $field['name']; ?>" class="form-control input-sm" id="<?php echo $field['name']; ?>" value="<?php echo $field_value; ?>">
                    <span class="help-block"><?php echo $field['help']; ?></span>
                </div>
            </div>
            <?php break;

        case 'textarea': ?>

            <div class="form-group wrap_<?php echo $field['name']; ?>">
                <label for="<?php echo $field['name']; ?>" class="col-sm-4 control-label"><?php echo $field['title']; ?></label>
                <div class="col-sm-8">
                    <textarea <?php echo (isset($field['disable']) && $field['disable']) ? 'disabled' : '' ; ?> name="<?php echo $field['name']; ?>" class="form-control" id="<?php echo $field['name']; ?>"><?php echo stripcslashes($field_value); ?></textarea>
                    <span class="help-block"><?php echo $field['help']; ?></span>
                </div>
            </div>
            <?php break;

        case 'select': ?>

            <div class="form-group wrap_<?php echo $field['name']; ?>">
                <label for="<?php echo $field['name']; ?>" class="col-sm-4 control-label"><?php echo $field['title']; ?></label>
                <div class="col-sm-8">
                    <select name="<?php echo $field['name']; ?>" id="<?php echo $field['name']; ?>" class="form-control input-sm">
                        <?php
                        if (isset($field['options']) && $field['options'] != '') {
                            foreach ($field['options'] as $val => $label) {
                                $selected = ($field_value == $val) ? 'selected' : '' ;
                                $disabled = (strpos($val, 'disabled')) ? 'disabled' : '' ;

                                echo '<option value="'.$val.'" '.$selected.' '.$disabled.'>'.$label.'</option>';
                            }
                        }
                        ?>
                    </select>
                    <span class="help-block"><?php echo $field['help']; ?></span>
                </div>
            </div>
            <?php break;

        case 'widget': ?>

            <div class="form-group wrap_<?php echo $field['name']; ?>">
                <label for="<?php echo $field['name']; ?>" class="col-sm-4 control-label"><?php echo $field['title']; ?></label>
                <div class="col-sm-8">
                    <select name="<?php echo $field['name']; ?>" id="<?php echo $field['name']; ?>" class="form-control input-sm">
                        <?php
                        $selected = ($field_value == '') ? 'selected' : '' ;
                        echo '<option value="" '.$selected.'>'.__( 'Disable', 'real-estate-manager' ).'</option>';
                        if (isset($GLOBALS['wp_registered_sidebars']) && $GLOBALS['wp_registered_sidebars'] != '') {
                            foreach ($GLOBALS['wp_registered_sidebars'] as $sidebar) {
                                $selected = ($field_value == $sidebar['id']) ? 'selected' : '' ;
                                $disabled = (strpos($field_value, 'disabled')) ? 'disabled' : '' ;

                                echo '<option value="'.$sidebar['id'].'" '.$selected.' '.$disabled.'>'.$sidebar['name'].'</option>';
                            }
                        }
                        ?>
                    </select>
                    <span class="help-block"><?php echo $field['help']; ?></span>
                </div>
            </div>
            <?php break;

        case 'pages': ?>

            <div class="form-group wrap_<?php echo $field['name']; ?>">
                <label for="<?php echo $field['name']; ?>" class="col-sm-4 control-label"><?php echo $field['title']; ?></label>
                <div class="col-sm-8">
                    <?php
                        $args = array(          
                            'post_type'   => 'page',
                            'posts_per_page'         => 500,
                        );          
                        $the_query_pages = new WP_Query( $args );

                        // The Loop
                        if ( $the_query_pages->have_posts() ) { ?>
                            <select name="<?php echo $field['name']; ?>" id="<?php echo $field['name']; ?>" class="form-control input-sm">
                            <?php while ( $the_query_pages->have_posts() ) {
                                $the_query_pages->the_post();
                                    $selected = ($field_value == get_the_id()) ? 'selected' : '' ;
                                ?>
                                    <option value="<?php the_id(); ?>" <?php echo $selected ?>><?php the_title(); ?></option>
                                <?php
                            } ?>
                            </select>
                            <?php wp_reset_postdata();
                        } else {
                            echo __( 'No Pages Found!', 'real-estate-manager' );
                        }
                    ?>
                    <span class="help-block"><?php echo $field['help']; ?></span>
                </div>
            </div>
            <?php break;

        case 'currency': ?>

            <div class="form-group wrap_<?php echo $field['name']; ?>">
                <label for="<?php echo $field['name']; ?>" class="col-sm-4 control-label"><?php echo $field['title']; ?></label>
                <div class="col-sm-8">
                    <select name="<?php echo $field['name']; ?>" id="<?php echo $field['name']; ?>" data-placeholder="<?php esc_attr_e( 'Choose a currency&hellip;', 'real-estate-manager' ); ?>" class="form-control input-sm">
                        <option value=""><?php _e( 'Choose a currency&hellip;', 'real-estate-manager' ); ?></option>
                        <?php
                        foreach ( rem_get_all_currencies() as $code => $name ) {
                            echo '<option value="' . esc_attr( $code ) . '" ' . selected( $field_value, $code, false ) . '>' . esc_html( $name . ' (' . rem_get_currency_symbol( $code ) . ')' ) . '</option>';
                        }
                        ?>
                    </select>
                    <span class="help-block"><?php echo $field['help']; ?></span>
                </div>
            </div>
            <?php break;

        case 'color': ?>

            <div class="form-group wrap_<?php echo $field['name']; ?>">
                <label for="<?php echo $field['name']; ?>" class="col-sm-4 control-label"><?php echo $field['title']; ?></label>
                <div class="col-sm-8">
                    <span class="wcp-color-wrap">
                        <input type="text" name="<?php echo $field['name']; ?>" id="<?php echo $field['name']; ?>" value="<?php echo $field_value; ?>" class="colorpicker" data-alpha="true">
                    </span>
                    <span class="help-block"><?php echo $field['help']; ?></span>
                </div>
            </div>
            <?php break;

        case 'image': ?>

                    <div class="form-group wrap_<?php echo $field['name']; ?>">
                        <label for="<?php echo $field['name']; ?>" class="col-sm-4 control-label">
                            <?php echo $field['title']; ?>
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control input-sm image-url" id="<?php echo $field['name']; ?>"
                                name="<?php echo $field['name']; ?>" value="<?php echo $field_value; ?>">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-info btn-sm upload_image_button" data-title="<?php _e( 'Image', 'real-estate-manager' ); ?>"
                        data-btntext="<?php _e( 'Select', 'real-estate-manager' ); ?>">
                                        <?php _e( 'Media', 'real-estate-manager' ); ?></button>
                                </span>
                            </div>
                            <span class="help-block"><?php echo $field['help']; ?></span>
                        </div>
                    </div>
            <?php break;

        case 'checkbox': ?>

            <div class="form-group wrap_<?php echo $field['name']; ?>">
                <label for="<?php echo $field['name']; ?>" class="col-sm-4 control-label"><?php echo $field['title']; ?></label>
                <div class="col-sm-8">
                    <div class="checkbox">
                        <label>
                            <?php $checked = ($field_value != '') ? 'checked' : '' ; ?>
                            <input type="checkbox" name="<?php echo $field['name']; ?>" id="<?php echo $field['name']; ?>" <?php echo $checked; ?>> <?php _e( 'Enable', 'real-estate-manager' ); ?>
                        </label>
                    </div>                            
                    <span class="help-block"><?php echo $field['help']; ?></span>
                </div>
            </div>
            <?php break;
        
        default:
            
            break;
    }
?>