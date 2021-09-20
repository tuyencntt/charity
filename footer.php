<?php
if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' ) ) {
    ?>
    <footer id="colophon" class="site-footer uk-container uk-container-large uk-margin-large-top uk-margin-large-bottom" >
        <div class="site-info" data-uk-grid>
            <div class="site-name uk-width-1-2@m uk-text-left@m uk-text-center">
                <?php if ( has_custom_logo() ) : ?>
                    <div class="site-logo"><?php the_custom_logo(); ?></div>
                <?php else : ?>
                    <?php if ( get_bloginfo( 'name' ) && get_theme_mod( 'display_title_and_tagline', true ) ) : ?>
                        <?php if ( is_front_page() && ! is_paged() ) : ?>
                            <?php bloginfo( 'name' ); ?>
                        <?php else : ?>
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div><!-- .site-name -->
            <div class="powered-by uk-width-1-2@m uk-text-right@m uk-text-center">
                <?php
                printf(
                /* translators: %s: WordPress. */
                    esc_html__( 'Proudly powered by %s.', 'charity' ),
                    '<a href="' . esc_url( 'https://templaza.com/' ) . '">'.esc_html('TemPlaza').'</a>'
                );
                ?>
            </div><!-- .powered-by -->

        </div><!-- .site-info -->
    </footer><!-- #colophon -->
<?php
}
wp_footer(); ?>
</body>
</html>
