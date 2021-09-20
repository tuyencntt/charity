<?php
use TemPlazaFramework\Functions;
if ( ! class_exists( 'CharityHandler' ) ) {
	/**
	 * Main theme class with configuration
	 */
	class CharityHandler {
		private static $instance;

		public function __construct() {
			require_once get_template_directory() . '/helpers/helper.php';
			require_once get_template_directory() . '/helpers/theme-functions.php';
			require_once get_template_directory() . '/plugins/class-tgm-plugin-activation.php';
			add_action( 'after_setup_theme', array( $this, 'charity_setup' ) );
			add_action( 'widgets_init', array( $this, 'charity_sidebar_registration' ) );
			add_action( 'init', array( $this, 'charity_register_theme_scripts' ) );
			add_filter( 'widget_title', 'do_shortcode' );
			add_filter( 'wp_nav_menu_items', 'do_shortcode' );
			add_action( 'wp_ajax_charity_portfolio_loadmore', array( $this, 'charity_portfolio_loadmore_ajax_handler' ) ); // wp_ajax_{action}
			add_action( 'wp_ajax_nopriv_charity_portfolio_loadmore', array( $this, 'charity_portfolio_loadmore_ajax_handler') ); // wp_ajax_nopriv_{action}
			add_action( 'pre_get_posts', array( $this, 'charity_set_posts_per_page_for_portfolio_cpt' ) );
			add_action( 'comment_form_before', array( $this, 'charity_enqueue_comments_reply' ) );
			add_filter( 'the_password_form', array( $this, 'charity_password_form' ), 10, 2 );
			add_action( 'tgmpa_register', array ( $this, 'charity_register_required_plugins' ) );
            add_filter( 'excerpt_more', array ( $this, 'charity_continue_reading_link_excerpt' ) );
            add_filter( 'the_content_more_link', array( $this, 'charity_continue_reading_link' ) );
            add_filter( 'excerpt_length', array($this,'charity_excerpt_length' ));
			get_template_part( 'inc/block-styles' );
			if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' ) || !class_exists( 'Redux_Framework_Plugin' ) ) {
				add_action( 'after_setup_theme', array( $this, 'charity_basic_setup' ) );
				add_action( 'init', array( $this, 'charity_basic_register_theme_scripts' ) );
                add_filter( 'dynamic_sidebar_params', array( $this, 'charity_add_widget_classes' ) );
			}
		}

		/**
		 * @return CharityHandler
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		function charity_setup() {
			load_theme_textdomain('charity', get_template_directory() . '/languages');
			add_theme_support( 'templaza-framework' );
			add_theme_support('post-formats', array('gallery', 'video', 'audio', 'link', 'quote'));
			add_theme_support('post-thumbnails');
			add_theme_support( 'title-tag' );
			add_theme_support( 'automatic-feed-links' );
			add_image_size( '600x400', 600, 400, array( 'center', 'center' ) ); // Hard crop center center
			add_theme_support(
			    'html5',
                array(
				    'script',
	                'style',
	                'comment-list',
                )
            );
			// Add theme support for selective refresh for widgets.
			add_theme_support( 'customize-selective-refresh-widgets' );
			// Add support for Block Styles.
			// Add support for responsive embedded content.
			add_theme_support( 'responsive-embeds' );

			// Add support for custom line height controls.
			add_theme_support( 'custom-line-height' );

			// Add support for experimental link color control.
			add_theme_support( 'experimental-link-color' );

			// Add support for experimental cover block spacing.
			add_theme_support( 'custom-spacing' );
			add_theme_support( 'align-wide' );

			// Add support for custom units.
			// This was removed in WordPress 5.6 but is still required to properly support WP 5.5.
			add_theme_support( 'custom-units' );
			add_theme_support( 'wp-block-styles' );
			add_theme_support( 'editor-styles' );
			add_editor_style( array( 'assets/css/style-editor.css', charity_basic_fonts_url()) );
		}

		function charity_sidebar_registration() {
			register_sidebar(
				array(
					'name'        => esc_html__( 'Top Sidebar', 'charity' ),
					'id'          => 'sidebar-top',
					'description' => esc_html__( 'Widgets in this area will be displayed in the first column in the top sidebar.', 'charity' ),
				)
			);
			register_sidebar(
				array(
					'name'        => esc_html__( 'Right Sidebar', 'charity' ),
					'id'          => 'sidebar-right',
					'description' => esc_html__( 'Widgets in this area will be displayed in the first column in the right sidebar.', 'charity' ),
				)
			);

			register_sidebar(
				array(
					'name'        => esc_html__( 'Left Sidebar', 'charity' ),
					'id'          => 'sidebar-left',
					'description' => esc_html__( 'Widgets in this area will be displayed in the first column in the left sidebar.', 'charity' ),
				)
			);

			register_sidebar(
				array(
					'name'        => esc_html__( 'Main Sidebar', 'charity' ),
					'id'          => 'sidebar-main',
					'description' => esc_html__( 'Widgets in this area will be displayed in the TemPlaza Framework layout builder sidebar only.', 'charity' ),
				)
			);

			register_sidebar(
				array(
					'name'        => esc_html__( 'Header Sidebar Mode', 'charity' ),
					'id'          => 'sidebar-mode',
					'description' => esc_html__( 'Widgets in this area will be displayed in the first column in the Sidebar - Header Mode of TemPlaza Framework only.', 'charity' ),
				)
			);
		}

		function charity_register_front_end_styles()
		{
			if(!is_child_theme()){
				wp_enqueue_style('charity-style', get_template_directory_uri() . '/style.css', false );
			}

		}

		function charity_register_front_end_scripts()
		{
			global $wp_query;
			wp_register_script( 'charity-portfolio-loadmore', get_template_directory_uri() . '/assets/js/portfolio-loadmore.min.js', array('jquery') );
			wp_localize_script( 'charity-portfolio-loadmore', 'charity_portfolio_loadmore_params', array(
				'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
				'posts' => json_encode( $wp_query->query_vars ), // everything about your loop is here
				'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
				'max_page' => $wp_query->max_num_pages,
				'category'  => get_queried_object_id()
			) );
			wp_enqueue_script( 'charity-portfolio-loadmore' );

			wp_register_script( 'charity-scripts', get_template_directory_uri() . '/assets/js/scripts.min.js', array('jquery') );
			wp_enqueue_script( 'charity-scripts' );
		}

		function charity_register_theme_scripts()
		{
			if ($GLOBALS['pagenow'] != 'wp-login.php') {
				if ( !is_admin() ) {
					add_action('wp_enqueue_scripts', array( $this, 'charity_register_front_end_styles' ) );
					add_action('wp_enqueue_scripts', array( $this, 'charity_register_front_end_scripts') );
				}
			}
		}

		function charity_portfolio_loadmore_ajax_handler(){
			// prepare our arguments for the query
			$args['post_type'] ='portfolio';
			$paged = $_POST['page'] + 1; // we need next page to be loaded
			$category   =   $_POST['category'];
			$args['post_status'] = 'publish';
			$options                = Functions::get_theme_options();
			$portfolios_per_page    = isset($options['portfolios_per_page']) && $options['portfolios_per_page'] ? $options['portfolios_per_page'] : get_option('posts_per_page');

			// it is always better to use WP_Query but not here
			$query_args = array(
				'post_type' => 'portfolio',
				'paged' => $paged,
				'posts_per_page' => $portfolios_per_page,
				'orderby'   =>  'date',
				'order' => 'DESC',
				'tax_query' => array(
					array(
						'taxonomy' => 'portfolio-category',
						'field' => 'id',
						'operator' => 'IN',
						'terms' => $category,
					)
				)
			);

			$charity_portfolio_query = new WP_Query( $query_args );

			if( $charity_portfolio_query->have_posts() ) :

				// run the loop
				while( $charity_portfolio_query->have_posts() ): $charity_portfolio_query->the_post();

					get_template_part( 'templaza-framework/templates/template-parts/portfolio/portfolio-content');

				endwhile;

			endif;
			wp_reset_postdata();
			die; // here we exit the script and even no wp_reset_query() required!
		}

		function charity_set_posts_per_page_for_portfolio_cpt( $query ) {
			if ( !is_admin() && $query->is_main_query() && (is_post_type_archive( 'portfolio' ) || is_tax('portfolio-category') || is_tax('portfolio_tag')) ) {
				$options                = Functions::get_theme_options();
				$portfolios_per_page    = isset($options['portfolios_per_page']) && $options['portfolios_per_page'] ? $options['portfolios_per_page'] : get_option('posts_per_page');
				$query->set( 'posts_per_page', $portfolios_per_page );
			}
		}

		function charity_enqueue_comments_reply() {
			if( get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}

		function charity_password_form( $output, $post = 0 ) {
			$post   = get_post( $post );
			$label  = 'pwbox-' . ( empty( $post->ID ) ? wp_rand() : $post->ID );
			$output = '<p class="post-password-message">' . esc_html__( 'This content is password protected. Please enter a password to view.', 'charity' ) . '</p>
	<p class="pass_label"> <label class="post-password-form__label" for="' . esc_attr( $label ) . '">' . esc_html_x( 'Password', 'Post password form', 'charity' ) . '</label></p>
	<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form" method="post">
	<input class="post-password-form__input" name="post_password" id="' . esc_attr( $label ) . '" type="password" size="20" />
	<input type="submit" class="post-password-form__submit" name="' . esc_attr_x( 'Submit', 'Post password form', 'charity' ) . '" value="' . esc_attr_x( 'Enter', 'Post password form', 'charity' ) . '" /></form>
	';
			return $output;
		}

		function charity_register_required_plugins()
		{
			/**
			 * Array of plugin arrays. Required keys are name and slug.
			 * If the source is NOT from the .org repo, then source is also required.
			 */
			$charity_plugins = array(

				// This is an example of how to include a plugin pre-packaged with a theme
				array(
					'name' => esc_html__('TemPlaza Framework', 'charity'), /* The plugin name */
					'slug' => 'templaza-framework', /* The plugin slug (typically the folder name) */
					'source' => get_template_directory_uri() . '/plugins/templaza-framework.zip', /* The plugin source */
					'required' => true, /* If false, the plugin is only 'recommended' instead of required */
					'version' => '1.0.1', /* E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented */
					'force_activation' => false, /* If true, plugin is activated upon theme activation and cannot be deactivated until theme switch */
					'force_deactivation' => false, /* If true, plugin is deactivated upon theme switch, useful for theme-specific plugins */
					'external_url' => '', /* If set, overrides default API URL and points to an external URL */
				),
				array(
					'name' => esc_html__('TemPlaza Elements', 'charity'), /* The plugin name */
					'slug' => 'templaza-elements', /* The plugin slug (typically the folder name) */
					'source' => get_template_directory_uri() . '/plugins/templaza-elements.zip', /* The plugin source */
					'required' => true, /* If false, the plugin is only 'recommended' instead of required */
					'version' => '1.0.0', /* E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented */
					'force_activation' => false, /* If true, plugin is activated upon theme activation and cannot be deactivated until theme switch */
					'force_deactivation' => false, /* If true, plugin is deactivated upon theme switch, useful for theme-specific plugins */
					'external_url' => '', /* If set, overrides default API URL and points to an external URL */
				),
				array(
					'name' => 'Redux Framework',
					'slug' => 'redux-framework',
					'required' => true,
				),
				array(
					'name' => 'Elementor Website Builder',
					'slug' => 'elementor',
					'required' => true,
				),
				array(
					'name' => 'Meta Box',
					'slug' => 'meta-box',
					'required' => true,
				),
				array(
					'name' => 'Contact Form by WPForms',
					'slug' => 'wpforms-lite',
					'required' => true,
				),
			);

			/**
			 * Array of configuration settings. Amend each line as needed.
			 * If you want the default strings to be available under your own theme domain,
			 * leave the strings uncommented.
			 * Some of the strings are added into a sprintf, so see the comments at the
			 * end of each line for what each argument will be.
			 */

			$charity_config = array(
				'id' => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
				'default_path' => '',                      // Default absolute path to bundled plugins.
				'menu' => 'tgmpa-install-plugins', // Menu slug.
				'parent_slug' => 'themes.php',            // Parent menu slug.
				'capability' => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
				'has_notices' => true,                    // Show admin notices or not.
				'dismissable' => true,                    // If false, a user cannot dismiss the nag message.
				'dismiss_msg' => '',                      // If 'dismissable' is false, this message will be output at top of nag.
				'is_automatic' => true,                   // Automatically activate plugins after installation or not.
				'message' => '',                      // Message to output right before the plugins table.
			);

			tgmpa($charity_plugins, $charity_config);
		}

		function charity_basic_setup(){
			register_nav_menus(
				array(
					'primary' => esc_html__( 'Primary menu', 'charity' ),
				)
			);
			$logo_width  = 115;
			$logo_height = 45;
			add_theme_support(
				'custom-logo',
				array(
					'height'               => $logo_height,
					'width'                => $logo_width,
					'flex-width'           => true,
					'flex-height'          => true,
					'unlink-homepage-logo' => true,
				)
			);
		}


		function charity_basic_register_front_end_styles()
		{
			wp_enqueue_style( 'charity-basic-fonts', charity_basic_fonts_url(), array(), null );
			wp_enqueue_style('charity-basic-style-min', get_template_directory_uri() . '/assets/css/style.min.css', false );
			wp_enqueue_style('charity-basic-fontawesome', get_template_directory_uri() . '/assets/css/fontawesome/css/all.min.css', false );
		}

		function charity_basic_register_front_end_scripts()
		{
			wp_enqueue_script('charity-basic-script-uikit', get_template_directory_uri() . '/assets/js/uikit.min.js', false );
			wp_enqueue_script('charity-basic-script-uikit-icon', get_template_directory_uri() . '/assets/js/uikit-icons.min.js', false );
			wp_enqueue_script('charity-basic-script-basic', get_template_directory_uri() . '/assets/js/basic.js', array('jquery') );
		}

		function charity_basic_register_theme_scripts()
		{
			if ($GLOBALS['pagenow'] != 'wp-login.php') {
				if ( !is_admin() )  {
					add_action('wp_enqueue_scripts', array( $this, 'charity_basic_register_front_end_styles' ) );
					add_action('wp_enqueue_scripts', array( $this, 'charity_basic_register_front_end_scripts' ) );
				}
			}
		}

		function charity_continue_reading_link_excerpt() {
			if ( ! is_admin() ) {
				return '&hellip; <a class="more-link" href="' . esc_url( get_permalink() ) . '">' . charity_basic_continue_reading_text() . '</a>';
			}
			return '';
		}

		function charity_continue_reading_link() {
			if ( ! is_admin() ) {
				return '<div class="more-link-container"><a class="more-link" href="' . esc_url( get_permalink() ) . '#more-' . esc_attr( get_the_ID() ) . '">' . charity_basic_continue_reading_text() . '</a></div>';
			}
			return '';
		}

		function charity_excerpt_length($length) {
            return 20;
		}

		function charity_add_widget_classes($params) {
            $params[0] = array_replace($params[0], array('before_widget' => str_replace("widget_block", "widget_block style1", $params[0]['before_widget'])));
            return $params;
		}

	}
	CharityHandler::get_instance();
}