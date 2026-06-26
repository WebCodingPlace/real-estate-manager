<div class="wrap wcp-main-wrap ich-settings-main-wrap">
    <h2><?php esc_attr_e( 'Agent Meta Fields Builder', 'real-estate-manager' ); ?></h2>

    <?php
        $fields_data = $this->rem_get_agent_fields_data_fields();
        $field_types = array(
            'text' => __( 'Text Field', 'real-estate-manager' ),
            'email'=> __( 'Email Field', 'real-estate-manager' ),
            'number'=> __( 'Number Field', 'real-estate-manager' ),
            'select'=> __( 'Dropdown Field', 'real-estate-manager' ),
            'textarea'=> __( 'Textarea Field', 'real-estate-manager' ),
            'checkbox'=> __( 'Checkbox Field', 'real-estate-manager' ),
            'password'=> __( 'Password Field', 'real-estate-manager' ),
            'image'=> __( 'Image Field', 'real-estate-manager' ),
        );
    ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-info">
                <span class="glyphicon glyphicon-info-sign"></span>
                <?php esc_attr_e( 'Drag and Drop the fields from Field Types into the Active Fields area.', 'real-estate-manager' ); ?>
                <?php esc_attr_e( 'Please do not change the Data Names of the default fields.', 'real-estate-manager' ); ?>
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
                        $fields = $this->get_agent_fields();
                        if(is_array($fields)) {
                            foreach ($fields as $data) {
                                $field_label = $field_types[$data['type']]; ?>
                                <div class="panel panel-default" data-type="<?php echo esc_attr($data['type']); ?>">
                                    <div class="panel-heading">
                                        <?php $this->rem_render_fields_builder_field_heading($data['title'], $field_label); ?>
                                    </div>
                                    <div class="panel-body inside-contents">
                                        <?php
                                            foreach ($fields_data as $field) {
                                                $this->rem_render_fields_builder_field($field, $data);
                                            }
                                        ?>
                                    </div>
                                </div>
                                
                            <?php }
                        }
                        ?>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>