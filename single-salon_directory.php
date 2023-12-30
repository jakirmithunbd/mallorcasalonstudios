<?php get_header();
$hero = get_field('hero_area', get_the_ID());
?>

<div class="quality-container">

    <section class="single-salon rounded" style="background-image: url(<?php echo $hero['image']['url']; ?>);">
        <div class="hero-content">
            <h1 class="text-center white"><?php echo get_the_title(); ?></h1>
        </div>
    </section>
</div>

<div class="quality-breadcrumb">
    <div class="quality-container">
        <?php echo custom_breadcrumb(); ?>
    </div>
</div>

<section class="salon-info">
    <div class="quality-container">
        <div class="salon-info-row">
            <div class="media rounded">
                <?php 
                    if (has_post_thumbnail()) {
                        the_post_thumbnail();
                    }

                    $tenant_name = get_field('tenant_name');
                    if ($tenant_name) {
                        printf('<h3 class="tenant-name">%s</h3>', $tenant_name);
                    }

                    $terms = get_the_terms(get_the_ID(), 'salon_type');

                    // Check if terms were retrieved
                    if ($terms && !is_wp_error($terms)) {
                        echo '<ul class="post-categories">';
                        foreach ($terms as $term) {
                            printf('<li><a href="%s">%s</a></li>', esc_url(get_term_link($term)), esc_html($term->name));
                        }
                        echo '</ul>';
                    }

                    $hours = get_field('hours');
                    if ($hours) {
                        printf('<div class="default-editor">%s</div>', $hours);
                    }
                ?>
            </div>

            <?php
                $suite = get_field('suite');
                $bio = get_field('bio');
                $salon_category = get_field('salon_category', get_the_ID());
            ?>

            <div class="info-content">
                <h2><?php echo get_the_title(); ?></h2>

                <?php

                if ($suite || $salon_category) {
                    printf('<h5 class="salon-meta">Suite %s <span class="dot"></span> %s</h5>', $suite, $salon_category);
                }

                $terms = get_the_terms(get_the_ID(), 'artist_tag');

                // Check if terms were retrieved
                if ($terms && !is_wp_error($terms)) {
                    echo '<ul class="post-categories artist-tags">';
                    foreach ($terms as $term) {
                        printf('<li><a href="%s">%s</a></li>', esc_url(get_term_link($term)), esc_html($term->name));
                    }
                    echo '</ul>';
                }

                    echo $bio;
                    // contacts
                    $contacts = get_field('contacts');
                    echo '<div class="contact-links">';
                    if ($contacts['booking_link']) {
                        printf('<a target="_blank" href="%s"><img src="%s"> Book Appointment </a>', $contacts['booking_link'], get_theme_file_uri('/assets/images/appointment.svg'));
                    }

                    if ($contacts['instagram']) {
                        printf('<a target="_blank" href="%s"><img src="%s"> Instagram </a>', $contacts['instagram'], get_theme_file_uri('/assets/images/instagram.svg'));
                    }

                    if ($contacts['tiktok']) {
                        printf('<a target="_blank" href="%s"><img src="%s"> Tiktok </a>', $contacts['tiktok'], get_theme_file_uri('/assets/images/tiktok.svg'));
                    }

                    if ($contacts['facebook']) {
                        printf('<a target="_blank" href="%s"><img src="%s"> Facebook </a>', $contacts['facebook'], get_theme_file_uri('/assets/images/facebook.svg'));
                    }

                    if ($contacts['call_or_text']) {
                        printf('<a href="tel:%s"><img src="%s"> Call Me </a>', $contacts['call_or_text'], get_theme_file_uri('/assets/images/phone.svg'));
                    }

                    if ($contacts['email']) {
                        printf('<a href="mailto:%s"><img src="%s"> Email </a>', $contacts['email'], get_theme_file_uri('/assets/images/email.svg'));
                    }
                echo '</div>';
                ?>
            </div>
        </div>

        <div class="gallery-group">
            <?php $gallery = get_field('gallery');
            if ($gallery) : foreach ($gallery as $item) : ?>
                    <a href="<?php echo $item['url']; ?>" class="media rounded">
                        <img src="<?php echo $item['url']; ?>" alt="<?php echo $item['tite']; ?>">
                    </a>
            <?php endforeach;
            endif; ?>
        </div>
    </div>
</section>
<div class="custom-footer-template">
    <?php $cta_templates = get_field('add_template_shortcode', get_the_ID());
        if($cta_templates) {
           echo do_shortcode($cta_templates); 
        } else {
            echo do_shortcode('[elementor-template id="2410"]');
        }
    ?>
</div>
<?php get_footer(); ?>