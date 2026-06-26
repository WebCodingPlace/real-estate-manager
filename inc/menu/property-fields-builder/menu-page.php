<div class="wrap wcp-main-wrap ich-settings-main-wrap">
    <h2><?php esc_attr_e( 'Property Fields Builder', 'real-estate-manager' ); ?></h2>

    <?php
        $saved_fields = get_option( 'rem_property_fields' );
        $fields_data = $this->rem_get_property_fields_data_fields();
        $field_types = array(
            'text' => __( 'Text Field', 'real-estate-manager' ),
            'number' => __( 'Number Field', 'real-estate-manager' ),
            'select' => __( 'DropDown Field', 'real-estate-manager' ),
            'select2' => __( 'Multi Select Field', 'real-estate-manager' ),
            'date' => __( 'Date Field', 'real-estate-manager' ),
            'button' => __( 'Button Field', 'real-estate-manager' ),
            'upload' => __( 'Files/Images Upload', 'real-estate-manager' ),
            'video' => __( 'Video URL', 'real-estate-manager' ),
            'textarea' => __( 'Text Area', 'real-estate-manager' ),
            'shortcode' => __( 'Shortcode', 'real-estate-manager' ),
            'countries' => __( 'Countries List', 'real-estate-manager' ),
            'states' => __( 'States List', 'real-estate-manager' ),
        );
        
        $field_types = apply_filters( 'rem_property_field_types', $field_types );
    ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-danger">
                <span class="glyphicon glyphicon-info-sign"></span>
                <?php esc_attr_e( 'This feature is available in the pro version.', 'real-estate-manager' ); ?>
                <a href="http://1.envato.market/01W74" target="_blank" class="btn btn-success btn-sm">
                    Explore Pro Features
                </a>
            </div>
            <div class="alert alert-info">
                <span class="glyphicon glyphicon-info-sign"></span>
                <?php esc_attr_e( 'Drag and Drop the fields from Field Types into the Active Fields area.', 'real-estate-manager' ); ?>
                <?php esc_attr_e( 'If Data Name contains the whole word "area", the chosen area unit will be shown after the value.', 'real-estate-manager' ); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php esc_attr_e( 'Field Types', 'real-estate-manager' ); ?></h3>
                </div>
                <div class="panel-body">
                    <div class="hard-coded-list">
                        <?php foreach ($field_types as $field_name => $field_label) { ?>
                        <div class="panel panel-default" data-type="<?php echo esc_attr($field_name); ?>">
                            <div class="panel-heading">
                                <?php $this->rem_render_fields_builder_field_heading('', $field_label); ?>
                            </div>
                            <div class="panel-body inside-contents">
                                <?php
                                    foreach ($fields_data as $field) {
                                        $this->rem_render_fields_builder_field($field, array('type' => $field_name));
                                    }
                                    do_action( 'rem_after_drag_drop_property_field', array('type' => $field_name) );
                                ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>  
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <button class="button btn-danger btn-md btn-block rem-reset-settings"><?php esc_attr_e( 'Reset Fields', 'real-estate-manager' ); ?></button>
                </div>
                <div class="col-sm-6">
                    <button class="button btn-success btn-md btn-block rem-save-settings"><?php esc_attr_e( 'Save Settings', 'real-estate-manager' ); ?></button>
                </div>
            </div>  
        </div>
        <div class="col-sm-9">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php esc_attr_e( 'Active Fields', 'real-estate-manager' ); ?></h3>
                </div>
                <div class="panel-body">
                    <div class="form-meta-setting form-horizontal">
                        <?php
                            include REM_PATH.'/inc/arrays/property-fields.php';
                            $fields = $inputFields;
                            foreach ($fields as $data) {
                                $field_label = $field_types[$data['type']]; ?>
                                <div class="panel panel-default" data-type="<?php echo esc_attr($data['type']); ?>">
                                    <div class="panel-heading title">
                                        <?php $this->rem_render_fields_builder_field_heading($data['title'], $field_label); ?>
                                    </div>
                                    <div class="panel-body inside-contents">
                                        <?php
                                            foreach ($fields_data as $field) {
                                                $this->rem_render_fields_builder_field($field, $data);
                                            }
                                            do_action( 'rem_after_drag_drop_property_field', $data );
                                        ?>
                                    </div>
                                </div>
                            <?php }
                        ?>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>