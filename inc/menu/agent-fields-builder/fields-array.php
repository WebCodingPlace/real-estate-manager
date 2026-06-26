<?php
	$fields = array(
        array(
            'type' => 'text',
            'name' => 'title',
            'title' => __( 'Label', 'real-estate-manager' ),
        ),
        array(
            'type' => 'text',
            'name' => 'key',
            'title' => __( 'Data Name (lowercase without spaces)', 'real-estate-manager' ),
        ),
        array(
            'type' => 'textarea',
            'name' => 'help',
            'title' => __( 'Help Text', 'real-estate-manager' ),
        ),
        array(
            'type' => 'textarea',
            'name' => 'options',
            'title' => __( 'Options (each per line)', 'real-estate-manager' ),
            'show_if' => array('select'),
        ),
        array(
            'type' => 'text',
            'name' => 'icon_class',
            'title' => __( 'Icon Class (If Agent Card Icons is selected)', 'real-estate-manager' ),
            'show_if' => array('text'),
        ),
        array(
            'type' => 'number',
            'name' => 'max_upload_size',
            'title' => __( 'Max File Size (in MB)', 'real-estate-manager' ),
            'show_if' => array('image'),
        ),
        array(
            'type' => 'text',
            'name' => 'file_types',
            'title' => __( 'File Types', 'real-estate-manager' ),
            'show_if' => array('image'),
        ),
        array(
            'type' => 'checkboxes',
            'name' => 'display',
            'title' => __( 'Display on', 'real-estate-manager' ),
            'options' => array(
                'register' => __( 'Registration Form', 'real-estate-manager' ),
                'admin' => __( 'Admin Profile Edit', 'real-estate-manager' ),
                'edit' => __( 'Frontend Edit', 'real-estate-manager' ),
                'card' => __( 'Agent Card Icons', 'real-estate-manager' ),
                'content' => __( 'Agent Page', 'real-estate-manager' ),
            )
        ),
        array(
            'type' => 'checkbox',
            'name' => 'required',
            'title' => __( 'Required', 'real-estate-manager' ),
        ),
        array(
            'type' => 'select',
            'name' => 'tab',
            'options' => rem_get_agent_fields_tabs(),
            'title' => __( 'Tab or Section', 'real-estate-manager' ),
        ),
	);
?>