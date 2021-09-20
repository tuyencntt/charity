<?php
    $id             = isset($atts['id'])?$atts['id']:time();
    $custom_class   = isset($atts['custom-container-class'])?' '.$atts['custom-container-class']:'';
    ?>
<div id="templaza-page-<?php echo esc_attr($id); ?>" class="templaza-page templaza-page-<?php echo get_post_type().esc_attr($custom_class);?>">
    <?php

    // Start the Loop.
    while ( have_posts() ) :
        the_post();
?>
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php
            the_content();

            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'charity' ),
                    'after'  => '</div>',
                )
            );
            ?>
        </div>
    <?php

        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) {
            comments_template();
        }
    endwhile; // End the loop.
    ?>

</div><!-- #main -->
