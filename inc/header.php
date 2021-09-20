<?php
$wrapper_classes  = 'site-header uk-container uk-container-expand uk-margin-top';
$wrapper_classes .= has_custom_logo() ? ' has-logo' : '';
$wrapper_classes .= ( true === get_theme_mod( 'display_title_and_tagline', true ) ) ? ' has-title-and-tagline' : '';
$wrapper_classes .= has_nav_menu( 'primary' ) ? ' has-menu' : '';
$blog_info    = get_bloginfo( 'name' );
$description  = get_bloginfo( 'description', 'display' );
$show_title   = ( true === get_theme_mod( 'display_title_and_tagline', true ) );
$header_class = $show_title ? 'site-title' : 'screen-reader-text';
class submenu_wrap extends Walker_Nav_Menu {
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class='uk-navbar-dropdown'><ul class='uk-nav uk-navbar-dropdown-nav'>\n";
    }
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div>\n";
    }
}
?>

<header id="masthead" class="<?php echo esc_attr( $wrapper_classes ); ?>" role="banner">
    <div class="uk-flex uk-flex-middle" data-uk-grid>
        <div class="uk-width-auto">
            <?php if ( has_custom_logo()) { ?>
                <div class="site-logo"><?php the_custom_logo(); ?></div>
            <?php }else{
                ?>
                <div class="site-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <img src="<?php echo esc_url(get_template_directory_uri().'/assets/images/logo.svg');?>" data-uk-svg>
                    </a>
                </div>
            <?php
            } ?>
        </div>
        <div class="uk-width-expand">
            <?php if ( has_nav_menu( 'primary' ) ) : ?>
            <div class="uk-text-right templaza-mobile-btn">
                <span class="open" data-uk-icon="icon: menu; ratio: 2"></span>
                <span class="close" data-uk-icon="icon: close; ratio: 2"></span>
            </div>
            <nav id="site-navigation" class="uk-navbar-container templaza-basic-navbar uk-navbar-transparent" data-uk-navbar>
                <?php
                wp_nav_menu(
                    array(
                        'theme_location'  => 'primary',
                        'menu_class'      => 'uk-navbar-nav',
                        'container_class' => 'uk-navbar-right',
                        'items_wrap'      => '<ul id="primary-menu-list" class="%2$s">%3$s</ul>',
                        'walker'          => new submenu_wrap()
                    )
                );
                ?>
            </nav><!-- #site-navigation -->
            <?php endif; ?>
        </div>
    </div>
</header>