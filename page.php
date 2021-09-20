<?php
get_header();
?>
    <div class="templaza-basic-single-heading uk-margin-xlarge  uk-text-center uk-container-small uk-container">
        <?php
        the_title( '<h1 class="page-title uk-heading-medium">', '</h1>' );
        do_action('templaza_breadcrumb');
        ?>
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
                get_template_part( 'templaza-framework/templates/theme_pages/page');
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