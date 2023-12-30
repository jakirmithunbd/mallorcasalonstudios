<?php
// Function to display custom post type category based posts
function quality_custom_post_type_category_posts_shortcode($atts)
{
    $terms = get_terms('salon_type');
    printf('<div class="salon-cate-wrapper quality-blog-search"> <div class="search-area"><input type="text" id="searchblogpost" placeholder="Ex: Hair Extensions" /></div> <div class="filter-nonce" data-nonce="%s"></div>', wp_create_nonce('filter_nonce'));

    // Check if terms were retrieved
    if ($terms && !is_wp_error($terms)) {
        printf('<div class="salon-type salon-cats"><h3>Locations:</h3><span data-slug="all">All</span>');
        foreach ($terms as $term) {
            printf('<span data-slug="%s">%s</span>', $term->slug, esc_html($term->name));
        }
        printf('</div>');
    } else {
        printf('No terms found.');
    }

    $terms_art = get_categories(array(
        'taxonomy' => 'artist_tag',
        'orderby' => 'count',
        'order' => 'DESC',
    ));

    // Check if terms were retrieved
    if ($terms_art && !is_wp_error($terms_art)) {
        printf('<div class="salon-type salon-tags"><h3>Recent Searches:</h3><span data-slug="all">All</span>');
        $counter = 0;
        foreach ($terms_art as $term) {
            printf('<span data-slug="%s">%s</span>', $term->slug, esc_html($term->name));
            $counter++;

            if ($counter === 20) {
                break;
            }
        }
        printf('</div>');
    } else {
        printf('No terms found.');
    }

    printf('</div><div class="salon-post-load" id="load-salon-posts"><img id="preloader" src="%s" /></div>', get_theme_file_uri('/assets/images/ajax-loader.gif'));
}

// Register shortcode
add_shortcode('mallorca_custom_post_type_category_posts', 'quality_custom_post_type_category_posts_shortcode');


// Posts Search By Ajax
function quality_posts_search_shortcode($atts)
{
    printf('<div class="quality-blog-search"><div class="search-area"><div class="search-nonce" data-searchnonce="%s"></div><input type="text" id="searchpost" placeholder="Seach" /></div>', wp_create_nonce('search_nonce'));

    printf('</div><div class="salon-post-load" id="load-searched-posts"><img id="preloader" src="%s" /></div>', get_theme_file_uri('/assets/images/ajax-loader.gif'));
}

// Register shortcode
add_shortcode('quality_posts_search', 'quality_posts_search_shortcode');

