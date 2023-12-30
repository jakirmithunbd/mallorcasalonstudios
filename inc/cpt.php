<?php
// Register Salon Directory Custom Post Type
function register_salon_directory_post_type()
{
    $labels = array(
        'name'               => _x('Salon Directory', 'post type general name', 'hello-elementor-child'),
        'singular_name'      => _x('Salon Directory', 'post type singular name', 'hello-elementor-child'),
        'menu_name'          => _x('Salon Directory', 'admin menu', 'hello-elementor-child'),
        'name_admin_bar'     => _x('Salon', 'add new on admin bar', 'hello-elementor-child'),
        'add_new'            => _x('Add New', 'salon', 'hello-elementor-child'),
        'add_new_item'       => __('Add New Salon', 'hello-elementor-child'),
        'new_item'           => __('New Salon', 'hello-elementor-child'),
        'edit_item'          => __('Edit Salon', 'hello-elementor-child'),
        'view_item'          => __('View Salon', 'hello-elementor-child'),
        'all_items'          => __('All Salons', 'hello-elementor-child'),
        'search_items'       => __('Search Salons', 'hello-elementor-child'),
        'parent_item_colon'  => __('Parent Salons:', 'hello-elementor-child'),
        'not_found'          => __('No salons found.', 'hello-elementor-child'),
        'not_found_in_trash' => __('No salons found in Trash.', 'hello-elementor-child'),
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __('Description.', 'hello-elementor-child'),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'salon-directory'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'thumbnail', 'custom-fields'),
    );

    register_post_type('salon_directory', $args);
}

add_action('init', 'register_salon_directory_post_type');

// Register Salon Types Taxonomy
function register_salon_types_taxonomy()
{
    $labels = array(
        'name'              => _x('Salon Types', 'hello-elementor-child'),
        'singular_name'     => _x('Salon Type', 'hello-elementor-child'),
        'search_items'      => __('Search Salon Types', 'hello-elementor-child'),
        'all_items'         => __('All Salon Types', 'hello-elementor-child'),
        'parent_item'       => __('Parent Salon Type', 'hello-elementor-child'),
        'parent_item_colon' => __('Parent Salon Type:', 'hello-elementor-child'),
        'edit_item'         => __('Edit Salon Type', 'hello-elementor-child'),
        'update_item'       => __('Update Salon Type', 'hello-elementor-child'),
        'add_new_item'      => __('Add New Salon Type', 'hello-elementor-child'),
        'new_item_name'     => __('New Salon Type Name', 'hello-elementor-child'),
        'menu_name'         => __('Salon Types', 'hello-elementor-child'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'salon-type'),
    );

    register_taxonomy('salon_type', array('salon_directory'), $args);
}

add_action('init', 'register_salon_types_taxonomy');

// Register Artist Tag Taxonomy
function register_artist_tag_taxonomy()
{
    $labels = array(
        'name'              => _x('Artist Tag', 'hello-elementor-child'),
        'singular_name'     => _x('Artist Tag', 'hello-elementor-child'),
        'search_items'      => __('Search Artist Tag', 'hello-elementor-child'),
        'all_items'         => __('All Artist Tags', 'hello-elementor-child'),
        'parent_item'       => __('Parent Artist Tag', 'hello-elementor-child'),
        'parent_item_colon' => __('Parent Artist Tag:', 'hello-elementor-child'),
        'edit_item'         => __('Edit Artist Tag', 'hello-elementor-child'),
        'update_item'       => __('Update Artist Tag', 'hello-elementor-child'),
        'add_new_item'      => __('Add New Artist Tag', 'hello-elementor-child'),
        'new_item_name'     => __('New Artist Tag Name', 'hello-elementor-child'),
        'menu_name'         => __('Artist Tag', 'hello-elementor-child'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'artist-tag'),
    );

    register_taxonomy('artist_tag', array('salon_directory'), $args);
}

add_action('init', 'register_artist_tag_taxonomy');
