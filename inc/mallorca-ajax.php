<?php
add_action( "wp_ajax_loadmore_posts", "quality_loadmore_posts_function" );
add_action( "wp_ajax_nopriv_loadmore_posts", "quality_loadmore_posts_function" );

function quality_loadmore_posts_function() {
    $data = isset( $_POST['data'] ) ? $_POST['data'] : '';
    $nonce = isset( $_POST['nonce'] ) ? $_POST['nonce'] : '';
    $searchPost = isset( $_POST['searchpost'] ) ? sanitize_text_field( $_POST['searchpost'] ) : false;

    if ( ! wp_verify_nonce( $nonce, 'filter_nonce' ) ) {
        wp_send_json_error( ['message' => '<div class="error-message">You are not in proper way!</div>'] );
        die();
    }

    $args = [
        'post_type'      => 'salon_directory',
        'posts_per_page' => -1,
        'orderby'        => 'rand',
    ];

    // Taxonomy query for both category and tags
    if ( ! empty( $data ) && isset( $data['salonSlug'] ) && isset( $data['filterType'] ) && sanitize_text_field( $data['salonSlug'] ) !== 'all' && ! $searchPost ) {
        $args['tax_query'][] = [
            'taxonomy' => sanitize_text_field( $data['filterType'] ), // Change this to your custom tags taxonomy name
            'field' => 'slug',
            'terms'    => sanitize_text_field( $data['salonSlug'] ),
        ];
    }

    // Search query
    if ( $searchPost ) {
        if ( isset( $args['tax_query'] ) ) {
            unset( $args['tax_query'] );
        }

        function get_all_term_list( $item ) {
            return [
                'name'     => $item->name,
                'taxonomy' => $item->taxonomy,
                'terms'    => $item->slug,
            ];
        }

        $term_list = array_map( 'get_all_term_list', get_terms() );

        function filter_terms( $item ) {
            $searchPost = isset( $_POST['searchpost'] ) ? sanitize_text_field( $_POST['searchpost'] ) : '';
            return is_numeric( strpos( strtolower( $item['name'] ), strtolower( $searchPost ) ) );
        }

        $search_terms = array_filter( $term_list, 'filter_terms' );

        function search_terms_filter( $item ) {
            return [
                'taxonomy' => $item['taxonomy'],
                'field'    => 'slug',
                'terms'    => $item['terms'],
            ];
        }
        $search_terms_filter = array_map( 'search_terms_filter', $search_terms );
        if ( empty( $search_terms_filter ) ) {
            $search_terms_filter[] = [
                'taxonomy' => 'Not Found',
                'field'    => 'slug',
                'terms'    => 'not-found',
            ];
        }

        $search_terms_filter['relation'] = 'OR';
        $args['tax_query'] = $search_terms_filter;

        $loop_taxonomy = new WP_Query( $args );

        unset( $args['tax_query'] );
        $args['s'] = $searchPost;
        $loop_search = new WP_Query( $args );
        unset( $args['s'] );

        $total_posts = array_merge( $loop_taxonomy->posts, $loop_search->posts );

        function filter_all_posts_ids( $item ) {
            return $item->ID;
        }

        $posts_ids = array_map( 'filter_all_posts_ids', $total_posts );
        $args['post__in'] = ! empty( $posts_ids ) ? $posts_ids : [0];
    }

    $loop = new WP_Query( $args );

    ob_start();

    if ( $loop->have_posts() ):
        while ( $loop->have_posts() ): $loop->the_post();?>
																																								            <article id="post-<?php the_ID();?>" <?php post_class( 'blog-box transition' );?>>
																																								                <?php
        $suite = get_field( 'suite', get_the_ID() );
            $salon_category = get_field( 'salon_category', get_the_ID() );
            printf( '<a class="media" href="%s"><img src="%s"/></a>', get_the_permalink(), get_the_post_thumbnail_url() );
            ?>

																																								                <div class="post-meta">
																																								                    <a class="post-titile" href="<?php the_permalink();?>"><?php the_title();?></a>
																																								                    <?php

            if ( $suite || $salon_category ) {
                printf( "<p class=\"salon-meta\">Suite %s <span class=\"dot\"></span> %s</p>", $suite, $salon_category );
            }

            $taxonomy_terms = get_the_terms( get_the_ID(), 'salon_type' );

            // Check if there are any terms
            if ( $taxonomy_terms && ! is_wp_error( $taxonomy_terms ) ) {
                foreach ( $taxonomy_terms as $term ) {
                    printf( '<div class="category">%s</div>', $term->name );
                }
            }

            $contacts = get_field( 'contacts', get_the_ID() );
            $colOne = $contacts['booking_link'] ? '' : 'colOne';
            echo '<div class="contact-links">';?>

																																								                    <div class="buttons-wrap <?php echo $colOne; ?>">
																																								                        <?php

            if ( $contacts['booking_link'] ) {
                printf( '<a target="_blank" class="btn" href="%s">%s</a>', $contacts['booking_link'], __( 'Book Appointment', 'hello-elementor-child' ) );
            }
            ?>

																																								                        <a class="btn" href="<?php the_permalink();?>"><?php _e( 'View Profile', 'hello-elementor-child' );?></a>
																																								                    </div>

																																								                </div>
																																								            </article><!-- / BLOG-BOX -->
																																								        <?php
    endwhile;
        wp_reset_postdata(); // Reset the post data after the loop
    else:
    ?>
        <div class="entry-content notResult col-md-12 col-sm-12 col-xs-12">
            <h4 class="no-content text-center" style="padding: 0 0 50px; margin-top: 30px;">
                <?php _e( 'No posts found!!!', 'hello-elementor-child' );?>
            </h4>
        </div>
<?php

    endif;
    $my_html = ob_get_contents();
    ob_end_clean();
    wp_send_json_success( ['page' => $my_html, 'nonce' => $nonce] );
    die();
}
