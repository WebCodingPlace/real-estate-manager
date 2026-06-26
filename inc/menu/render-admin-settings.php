<?php

	$saved_settings = get_option( 'rem_all_settings' );
    $default = (isset($field['default'])) ? $field['default'] : '' ;
    $field_value = (isset($saved_settings[$field['name']])) ? $saved_settings[$field['name']] : $default ;
    if (!is_array($field_value)) {
        $field_value = stripcslashes($field_value);
    }
    $c_data = '';
    if (isset($field['show_if']) && is_array($field['show_if'])) {
        $c_field = $field['show_if'][0];
        $c_value = $field['show_if'][1];
        $c_data = "data-cond-option=$c_field";
        $c_data .= " data-cond-value=$c_value";
    }

    switch ($field['type']) {

        case 'text': ?>

            <div class="form-group wrap_<?php echo esc_attr($field['name']); ?>" <?php echo esc_attr($c_data); ?>>
                <label for="<?php echo esc_attr($field['name']); ?>" class="col-sm-4 control-label"><?php echo esc_attr($field['title']); ?></label>
                <div class="col-sm-8">
                    <input type="text" name="<?php echo esc_attr($field['name']); ?>" class="form-control input-sm" id="<?php echo esc_attr($field['name']); ?>" value="<?php echo esc_attr($field_value); ?>">
                    <span class="help-block"><?php echo wp_kses_post($field['help']); ?></span>
                </div>
            </div>
            <?php break;

        case 'color': ?>

            <div class="form-group wrap_<?php echo esc_attr($field['name']); ?>" <?php echo esc_attr($c_data); ?>>
                <label for="<?php echo esc_attr($field['name']); ?>" class="col-sm-4 control-label"><?php echo esc_attr($field['title']); ?></label>
                <div class="col-sm-8">
                    <input type="text" name="<?php echo esc_attr($field['name']); ?>" class="form-control input-sm colorpicker" id="<?php echo esc_attr($field['name']); ?>" value="<?php echo esc_attr($field_value); ?>">
                    <span class="help-block"><?php echo wp_kses_post($field['help']); ?></span>
                </div>
            </div>
            <?php break;

        case 'number': ?>

            <div class="form-group wrap_<?php echo esc_attr($field['name']); ?>" <?php echo esc_attr($c_data); ?>>
                <label for="<?php echo esc_attr($field['name']); ?>" class="col-sm-4 control-label"><?php echo esc_attr($field['title']); ?></label>
                <div class="col-sm-8">
                    <input type="number" name="<?php echo esc_attr($field['name']); ?>" class="form-control input-sm" id="<?php echo esc_attr($field['name']); ?>" value="<?php echo esc_attr($field_value); ?>">
                    <span class="help-block"><?php echo wp_kses_post($field['help']); ?></span>
                </div>
            </div>
            <?php break;

        case 'textarea':
            $help = $field['help'];
            $disabled = '';
            ?>

            <div class="form-group wrap_<?php echo esc_attr($field['name']); ?>" <?php echo esc_attr($c_data); ?>>
                <label for="<?php echo esc_attr($field['name']); ?>" class="col-sm-4 control-label"><?php echo esc_attr($field['title']); ?></label>
                <div class="col-sm-8">
                    <textarea <?php echo esc_attr($disabled); ?> name="<?php echo esc_attr($field['name']); ?>" class="form-control" id="<?php echo esc_attr($field['name']); ?>"><?php echo (is_array($field_value)) ? implode("\n", $field_value) : esc_attr($field_value); ?></textarea>
                    <span class="help-block"><?php echo wp_kses_post($help); ?></span>
                </div>
            </div>
            <?php break;

        case 'select': ?>
            <?php
                $multiple =  '';
                $field_name =  $field['name'];
                if ((isset($field['multiple']) && $field['multiple'] == 'true')) {
                    $multiple =  'multiple';
                    $field_name =  $field['name'].'[]';
                }
            ?>
            <div class="form-group wrap_<?php echo esc_attr($field['name']); ?>" <?php echo esc_attr($c_data); ?>>
                <label for="<?php echo esc_attr($field['name']); ?>" class="col-sm-4 control-label"><?php echo esc_attr($field['title']); ?></label>
                <div class="col-sm-8">
                    <select <?php echo esc_attr($multiple); ?> name="<?php echo esc_attr($field_name); ?>" id="<?php echo esc_attr($field['name']); ?>" class="form-control input-sm">
                        <?php
                        if (isset($field['options']) && $field['options'] != '') {
                            foreach ($field['options'] as $val => $label) {
                                if (is_array($field_value)) {
                                    $selected = (in_array($val, $field_value)) ? 'selected' : '' ;
                                } else {
                                    $selected = ($field_value == $val) ? 'selected' : '' ;
                                }
                                $disabled = (strpos($val, 'disabled')) ? 'disabled' : '' ;

                                echo '<option value="'.esc_attr($val).'" '.esc_attr($selected).' '.esc_attr($disabled).'>'.esc_attr($label).'</option>';
                            }
                        }
                        ?>
                    </select>
                    <span class="help-block"><?php echo wp_kses_post($field['help']); ?></span>
                </div>
            </div>
            <?php break;

        case 'image_sizes': ?>

            <div class="form-group wrap_<?php echo esc_attr($field['name']); ?>" <?php echo esc_attr($c_data); ?>>
                <label for="<?php echo esc_attr($field['name']); ?>" class="col-sm-4 control-label"><?php echo esc_attr($field['title']); ?></label>
                <div class="col-sm-8">
                    <select name="<?php echo esc_attr($field['name']); ?>" id="<?php echo esc_attr($field['name']); ?>" class="form-control input-sm">
                        <?php
                        echo '<option value="">'.__( 'Default', 'real-estate-manager' ).'</option>';
                        $image_sizes = get_intermediate_image_sizes();
                        foreach ($image_sizes as $val) {
                            $selected = ($field_value == $val) ? 'selected' : '' ;
                            $disabled = (strpos($val, 'disabled')) ? 'disabled' : '' ;

                            echo '<option value="'.esc_attr($val).'" '.esc_attr($selected).' '.esc_attr($disabled).'>'.esc_attr($val).'</option>';                            
                        }
                        ?>
                    </select>
                    <span class="help-block"><?php echo wp_kses_post($field['help']); ?></span>
                </div>
            </div>
            <?php break;

        case 'widget': ?>

            <div class="form-group wrap_<?php echo esc_attr($field['name']); ?>" <?php echo esc_attr($c_data); ?>>
                <label for="<?php echo esc_attr($field['name']); ?>" class="col-sm-4 control-label"><?php echo esc_attr($field['title']); ?></label>
                <div class="col-sm-8">
                    <select name="<?php echo esc_attr($field['name']); ?>" id="<?php echo esc_attr($field['name']); ?>" class="form-control input-sm">
                        <?php
                        $selected = ($field_value == '') ? 'selected' : '' ;
                        echo '<option value="" '.$selected.'>'.__( 'Disable', 'real-estate-manager' ).'</option>';
                        if (isset($GLOBALS['wp_registered_sidebars']) && $GLOBALS['wp_registered_sidebars'] != '') {
                            foreach ($GLOBALS['wp_registered_sidebars'] as $sidebar) {
                                $selected = ($field_value == $sidebar['id']) ? 'selected' : '' ;
                                $disabled = (strpos($field_value, 'disabled')) ? 'disabled' : '' ;

                                echo '<option value="'.esc_attr($sidebar['id']).'" '.esc_attr($selected).' '.esc_attr($disabled).'>'.esc_attr($sidebar['name']).'</option>';
                            }
                        }
                        ?>
                    </select>
                    <span class="help-block"><?php echo wp_kses_post($field['help']); ?></span>
                </div>
            </div>
            <?php break;

        case 'pages': ?>

            <div class="form-group wrap_<?php echo esc_attr($field['name']); ?>" <?php echo esc_attr($c_data); ?>>
                <label for="<?php echo esc_attr($field['name']); ?>" class="col-sm-4 control-label"><?php echo esc_attr($field['title']); ?></label>
                <div class="col-sm-8">
                    <?php
                        $args = array(          
                            'post_type'   => 'page',
                            'posts_per_page'         => 500,
                        );          
                        $the_query_pages = new WP_Query( $args );

                        // The Loop
                        if ( $the_query_pages->have_posts() ) { ?>
                            <select name="<?php echo esc_attr($field['name']); ?>" id="<?php echo esc_attr($field['name']); ?>" class="form-control input-sm">
                            <?php while ( $the_query_pages->have_posts() ) {
                                $the_query_pages->the_post();
                                    $selected = ($field_value == get_the_id()) ? 'selected' : '' ;
                                ?>
                                    <option value="<?php the_id(); ?>" <?php echo esc_attr($selected) ?>><?php the_title(); ?></option>
                                <?php
                            } ?>
                            </select>
                            <?php wp_reset_postdata();
                        } else {
                            echo __( 'No Pages Found!', 'real-estate-manager' );
                        }
                    ?>
                    <span class="help-block"><?php echo wp_kses_post($field['help']); ?></span>
                </div>
            </div>
            <?php break;

        case 'currency': ?>

            <div class="form-group wrap_<?php echo esc_attr($field['name']); ?>" <?php echo esc_attr($c_data); ?>>
                <label for="<?php echo esc_attr($field['name']); ?>" class="col-sm-4 control-label"><?php echo esc_attr($field['title']); ?></label>
                <div class="col-sm-8">
                    <select name="<?php echo esc_attr($field['name']); ?>" id="<?php echo esc_attr($field['name']); ?>" data-placeholder="<?php esc_attr_e( 'Choose a currency&hellip;', 'real-estate-manager' ); ?>" class="form-control input-sm">
                        <option value=""><?php esc_attr_e( 'Choose a currency&hellip;', 'real-estate-manager' ); ?></option>
                        <?php
                        foreach ( rem_get_all_currencies() as $code => $name ) {
                            echo '<option value="' . esc_attr( $code ) . '" ' . selected( $field_value, $code, false ) . '>' . esc_html( $name . ' (' . rem_get_currency_symbol( $code ) . ')' ) . '</option>';
                        }
                        ?>
                    </select>
                    <span class="help-block"><?php echo wp_kses_post($field['help']); ?></span>
                </div>
            </div>
            <?php break;

        case 'image': ?>

                    <div class="form-group wrap_<?php echo esc_attr($field['name']); ?>" <?php echo esc_attr($c_data); ?>>
                        <label for="<?php echo esc_attr($field['name']); ?>" class="col-sm-4 control-label">
                            <?php echo esc_attr($field['title']); ?>
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control input-sm image-url" id="<?php echo esc_attr($field['name']); ?>"
                                name="<?php echo esc_attr($field['name']); ?>" value="<?php echo esc_attr($field_value); ?>">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-info btn-sm upload_image_button" data-title="<?php esc_attr_e( 'Image', 'real-estate-manager' ); ?>"
                        data-btntext="<?php esc_attr_e( 'Select', 'real-estate-manager' ); ?>">
                                        <?php esc_attr_e( 'Media', 'real-estate-manager' ); ?></button>
                                </span>
                            </div>
                            <span class="help-block"><?php echo wp_kses_post($field['help']); ?></span>
                        </div>
                    </div>
            <?php break;

        case 'checkbox': ?>

            <div class="form-group wrap_<?php echo esc_attr($field['name']); ?>" <?php echo esc_attr($c_data); ?>>
                <label for="<?php echo esc_attr($field['name']); ?>" class="col-sm-4 control-label"><?php echo esc_attr($field['title']); ?></label>
                <div class="col-sm-8">
                    <div class="checkbox">
                        <label>
                            <?php $checked = ($field_value != '') ? 'checked' : '' ; ?>
                            <input type="checkbox" name="<?php echo esc_attr($field['name']); ?>" id="<?php echo esc_attr($field['name']); ?>" <?php echo esc_attr($checked); ?>> <?php esc_attr_e( 'Enable', 'real-estate-manager' ); ?>
                        </label>
                    </div>                            
                    <span class="help-block"><?php echo wp_kses_post($field['help']); ?></span>
                </div>
            </div>
            <?php break;
        
        default:
            
            break;
    }
?>