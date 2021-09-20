<?php
get_header();
$description = get_the_archive_description();
?>
    <div class="templaza-basic-single-heading uk-margin-xlarge  uk-text-center uk-container-small uk-container">
        <?php
        the_archive_title( '<h1 class="page-title uk-heading-medium">', '</h1>' );
        do_action('templaza_breadcrumb');
        if ( $description ) : ?>
            <div class="archive-description"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
        <?php endif; ?>
    </div>
    <div class="templaza-basic-wrap uk-container uk-container-large">
        <div data-uk-grid>
            <?php
            if ( is_active_sidebar( 'sidebar-left' ) ) {
                ?>
                <div class="uk-width-1-4@m templaza-sidebar">
                    <?php dynamic_sidebar( 'sidebar-left' ); ?>
                </div>
                <?php
            }
            ?>
            <div class="uk-width-expand@m">
                <?php
                get_template_part( 'templaza-framework/templates/theme_pages/archive');
                ?>
            </div>
            <?php
            if ( is_active_sidebar( 'sidebar-right' ) ) {
                ?>
                <div class="uk-width-1-4@m templaza-sidebar">
                    <?php dynamic_sidebar( 'sidebar-right' ); ?>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<?php
get_footer();