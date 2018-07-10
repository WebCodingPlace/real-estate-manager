<?php
    $inputFields = $this->single_property_fields();

    $property_individual_cbs = $this->get_all_property_features();

    foreach ($property_individual_cbs as $cb) {
        $field_option = array(
            'key' => $cb,
            'type' => 'checkbox',
            'tab' => 'property_details',
            'default' => '',
            'accessibility' => 'public',
            'title' => $cb,
            'help' => __( 'Check if property have this option', 'real-estate-manager' ),
        );
        $inputFields[] = $field_option;
    }
?>