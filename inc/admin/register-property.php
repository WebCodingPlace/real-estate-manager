<?php
    
    $menu_name = __( 'Real Estate Manager', 'real-estate-manager' );

    if (current_user_can('edit_rem_property') && !current_user_can('edit_others_rem_properties')) {
        $menu_name = __( 'Properties', 'real-estate-manager' );
    }

    $custom_labels = array(
        'name'                => __( 'Properties', 'real-estate-manager' ),
        'singular_name'       => __( 'Property', 'real-estate-manager' ),
        'add_new'             => _x( 'Add New Property', 'real-estate-manager', 'real-estate-manager' ),
        'add_new_item'        => __( 'Add New Property', 'real-estate-manager' ),
        'edit_item'           => __( 'Edit Property', 'real-estate-manager' ),
        'new_item'            => __( 'New Property', 'real-estate-manager' ),
        'view_item'           => __( 'View Property', 'real-estate-manager' ),
        'search_items'        => __( 'Search Property', 'real-estate-manager' ),
        'not_found'           => __( 'No Property found', 'real-estate-manager' ),
        'not_found_in_trash'  => __( 'No Property found in Trash', 'real-estate-manager' ),
        'parent_item_colon'   => __( 'Parent Property:', 'real-estate-manager' ),
        'menu_name'           => $menu_name,
        'all_items'           => __( 'Properties', 'real-estate-manager' ),
    );

    $s_rem_slug = get_option( 'rem_property_permalink' );
    $rem_slug = ($s_rem_slug != '') ? $s_rem_slug : 'property' ;    

    $anim_args = array(
        'labels'              => $custom_labels,
        'hierarchical'        => false,
        'description'         => 'Properties',
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => null,
        'menu_icon'           => 'dashicons-admin-home',
        'show_in_nav_menus'   => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'has_archive'         => true,
        'query_var'           => true,
        'can_export'          => true,
        'rewrite'             => array(
                            'slug'          => $rem_slug,
                            'with_front'    => false
        ),
        'capability_type'     => array('rem_property', 'rem_properties'),
        'map_meta_cap'        => true,
        'supports'            => array(
            'title', 'editor', 'author', 'thumbnail', 'excerpt'
            )
    );

    register_post_type( 'rem_property', $anim_args );

    /**
     * Create a property_tag
     *
     * @uses  Inserts new taxonomy object into the list
     * @uses  Adds query vars
     *
     * @param string  Name of taxonomy object
     * @param array|string  Name of the object type for the taxonomy object.
     * @param array|string  Taxonomy arguments
     * @return null|WP_Error WP_Error if errors, otherwise null.
     */
    
    $tax_labels = array(
        'name'                    => _x( 'Property Tags', 'Property Tags', 'real-estate-manager' ),
        'singular_name'            => _x( 'Tag', 'Tags', 'real-estate-manager' ),
        'search_items'            => __( 'Search Property Tags', 'real-estate-manager' ),
        'popular_items'            => __( 'Popular Tags', 'real-estate-manager' ),
        'all_items'                => __( 'All Tags', 'real-estate-manager' ),
        'parent_item'            => __( 'Parent Tag', 'real-estate-manager' ),
        'parent_item_colon'        => __( 'Parent Tag', 'real-estate-manager' ),
        'edit_item'                => __( 'Edit Tag', 'real-estate-manager' ),
        'update_item'            => __( 'Update Tag', 'real-estate-manager' ),
        'add_new_item'            => __( 'Add New Tag', 'real-estate-manager' ),
        'new_item_name'            => __( 'New Tag Name', 'real-estate-manager' ),
        'add_or_remove_items'    => __( 'Add or remove Tags', 'real-estate-manager' ),
        'choose_from_most_used'    => __( 'Choose from most used tags', 'real-estate-manager' ),
        'menu_name'                => __( ' Tags', 'real-estate-manager' ),
    );

    $tax_args = array(
        'labels'            => $tax_labels,
        'public'            => true,
        'show_in_nav_menus' => true,
        'show_admin_column' => true,
        'hierarchical'      => false,
        'show_tagcloud'     => true,
        'show_ui'           => true,
        'query_var'         => true,
        'rewrite'             => array(
                            'slug'          => 'property_tag',
                            'with_front'    => false
        ),            
        'query_var'         => true,
    );

    register_taxonomy( 'rem_property_tag', array( 'rem_property' ), $tax_args );
?>