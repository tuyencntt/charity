<?php
get_header();
?>
    <div class="templaza-basic-wrap uk-container uk-container-large uk-margin-xlarge-top">
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
                get_template_part( 'templaza-framework/templates/theme_pages/index');
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