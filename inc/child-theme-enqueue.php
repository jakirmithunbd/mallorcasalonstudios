<?php
add_action('wp_enqueue_scripts', 'hello_elementor_child_style');
function hello_elementor_child_style()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
   
    wp_enqueue_style("slick_min_style", get_theme_file_uri('/assets/css/slick-slider.css'), array(), '1.0.0');
    wp_enqueue_style("main_custom_style", get_theme_file_uri('/assets/css/hello-child-style.css'), array(), time());

    wp_enqueue_script('scripts-slick-js', get_theme_file_uri('/assets/js/slick.min.js'), array('jquery'), '1.0.0', true);
    wp_enqueue_script('scripts-js', get_theme_file_uri('/assets/js/hello-child-scripts.js'), array('jquery', 'wp-util'), time(), true);
    $data = array(
        'site_url' => get_template_directory_uri(),
        'preloader' => '/wp-content/themes/hello-elementor-child/assets/images/ajax-loader.gif',
        'admin_ajax'   => admin_url('admin-ajax.php'),
    );
    wp_localize_script('scripts-js', 'ajax', $data);
}