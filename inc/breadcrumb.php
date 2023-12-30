<?php 

function custom_breadcrumb()
{
    $separator = ' &gt; ';
    $home_text = 'Home';

    global $post;

    $output = '';
    $home_link = home_url('/');

    if (is_home() || is_front_page()) {
        $output .= '<a href="' . $home_link . '">' . $home_text . '</a>' . $separator;
    } else {
        $output .= '<a href="' . $home_link . '">' . $home_text . '</a>' . $separator;
    }

    if (is_singular('custom_post_type')) {
        $post_type = get_post_type_object(get_post_type());
        $output .= '<a href="' . get_post_type_archive_link('custom_post_type') . '">' . $post_type->labels->singular_name . '</a>' . $separator;
    }

    if (is_singular()) {
        $post_type = get_post_type_object(get_post_type());
        $output .= '<a href="' . get_post_type_archive_link($post_type->name) . '">' . $post_type->labels->singular_name . '</a>' . $separator;
        $output .= get_the_title();
    }

    echo $output;
}


function custom_breadcrumb_shortcode()
{
    $separator = ' &gt; ';
    $home_text = 'Home';

    global $post;

    $output = '';
    $home_link = home_url('/');

    if (is_home() || is_front_page()) {
        $output .= '<a href="' . $home_link . '">' . $home_text . '</a>' . $separator;
    } else {
        $output .= '<a href="' . $home_link . '">' . $home_text . '</a>' . $separator;
    }

    if (is_singular('custom_post_type')) {
        $post_type = get_post_type_object(get_post_type());
        $output .= '<a href="' . get_post_type_archive_link('custom_post_type') . '">' . $post_type->labels->singular_name . '</a>' . $separator;
    }

    if (is_singular()) {
        $post_type = get_post_type_object(get_post_type());
        $output .= '<a href="' . get_post_type_archive_link($post_type->name) . '">' . $post_type->labels->singular_name . '</a>' . $separator;
        $output .= get_the_title();
    }

    return $output;
}

add_shortcode('custom_breadcrumb', 'custom_breadcrumb_shortcode');

