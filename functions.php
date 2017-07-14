<?php
/**
 * Genesis Sample.
 *
 * This file adds functions to the Genesis Sample Theme.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'genesis_sample_localization_setup' );
function genesis_sample_localization_setup(){
	load_child_theme_textdomain( 'genesis-sample', get_stylesheet_directory() . '/languages' );
}

// Add the helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Add Image upload and Color select to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Add WooCommerce support.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Add the required WooCommerce styles and Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php' );

// Add the Genesis Connect WooCommerce notice.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Genesis Sample' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );
define( 'CHILD_THEME_VERSION', '2.3.0' );

// Enqueue Scripts and Styles.
add_action( 'wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles' );
function genesis_sample_enqueue_scripts_styles() {

	wp_enqueue_style( 'genesis-sample-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'genesis-sample-responsive-menu', get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'genesis-sample-responsive-menu',
		'genesis_responsive_menu',
		genesis_sample_responsive_menu_settings()
	);

}

// Define our responsive menu settings.
function genesis_sample_responsive_menu_settings() {

	$settings = array(
		'mainMenu'          => __( 'Menu', 'genesis-sample' ),
		'menuIconClass'     => 'dashicons-before dashicons-menu',
		'subMenu'           => __( 'Submenu', 'genesis-sample' ),
		'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'       => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'width'           => 600,
	'height'          => 160,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

// Add support for custom background.
add_theme_support( 'custom-background' );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Add Image Sizes.
add_image_size( 'featured-image', 720, 400, TRUE );

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'After Header Menu', 'genesis-sample' ), 'secondary' => __( 'Footer Menu', 'genesis-sample' ) ) );

// Reposition the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

// Reduce the secondary navigation menu to one level depth.
add_filter( 'wp_nav_menu_args', 'genesis_sample_secondary_menu_args' );
function genesis_sample_secondary_menu_args( $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;

}

// Modify size of the Gravatar in the author box.
add_filter( 'genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar' );
function genesis_sample_author_box_gravatar( $size ) {
	return 90;
}

// Modify size of the Gravatar in the entry comments.
add_filter( 'genesis_comment_list_args', 'genesis_sample_comments_gravatar' );
function genesis_sample_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;

	return $args;

}

// Customizations --------------------------------------------------------------------------------

// Fonts
add_action( 'wp_enqueue_scripts', 'sp_load_google_lato_font');
function sp_load_google_lato_font() {
	wp_enqueue_style( 'google-font-lato', '//fonts.googleapis.com/css?family=Lato:300,500,600,700', array(), CHILD_THEME_VERSION );
}

add_action( 'wp_enqueue_scripts', 'sp_load_pt_serif_font');
function sp_load_pt_serif_font() {
	wp_enqueue_style( 'genesis-font-pt-serif', '//fonts.googleapis.com/css?family=PT+Serif:400', array(), CHILD_THEME_VERSION );
}

add_action( 'wp_enqueue_scripts', 'sp_load_hind_font');
function sp_load_hind_font() {
	wp_enqueue_style( 'genesis-font-hind-serif', '//fonts.googleapis.com/css?family=Hind:400,500,600,700', array(), CHILD_THEME_VERSION );
}

// Layout
//add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Title
remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
add_action( 'genesis_site_title', 'child_seo_site_title' );
function child_seo_site_title() { 
	echo '<h1 class="site-title">What I Read</h1>';
}

remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
/*
add_action( 'genesis_site_description', 'child_seo_site_description' );
function child_seo_site_description() { 
	echo '<h2 class="site-description" itemprop="description">Katell Le Goulven</h2>';
}
*/

add_filter( 'wp_nav_menu_items', 'theme_menu_extras', 10, 2 );
/**
 * Filter menu items, appending either a search form or today's date.
 *
 * @param string   $menu HTML string of list items.
 * @param stdClass $args Menu arguments.
 *
 * @return string Amended HTML string of list items.
 */
function theme_menu_extras( $menu, $args ) {
	//* Change 'primary' to 'secondary' to add extras to the secondary navigation menu
	//if ( 'secondary' !== $args->theme_location )
    //		return $menu;
	//* Uncomment this block to add a search form to the navigation menu
	ob_start();
	get_search_form();
	$search = ob_get_clean();
	$menu  .= '<li class="right search">' . $search . '</li>';
	//* Uncomment this block to add the date to the navigation menu
	/*
	$menu .= '<li class="right date">' . date_i18n( get_option( 'date_format' ) ) . '</li>';
	*/
	return $menu;
}

//* Add Dashicon to search form button 
add_filter( 'genesis_search_button_text', 'b3m_search_button_dashicon' );
function b3m_search_button_dashicon( $text ) {
	return esc_attr( '&#xf179;' );
}

//* Customize search form input box text
add_filter( 'genesis_search_text', 'sp_search_text' );
function sp_search_text( $text ) {
	return esc_attr( 'Search' );
}

//* Remove page title for multiple pages (requires HTML5 theme support)
//* Change '3645' and '4953' to match your needs
add_action( 'get_header', 'child_remove_page_titles' );
function child_remove_page_titles() {
    $pages = array( 2,122,132 );
    if ( is_page( $pages ) ) {
        remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
    }
}

/** Exclude page from search results */
add_filter('pre_get_posts','SearchFilter');
function SearchFilter($query) {
    if ($query->is_search) {
        $query->set('post__not_in', array(2, 122, 132));
    }
    return $query;
}

//* Remove the site footer
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

//* Customize the site footer
add_action( 'genesis_footer', 'bg_custom_footer' );
function bg_custom_footer() { 
	echo '<div class="site-footer custom-footer"><p>Find me on <a class="linkedin" href="https://www.linkedin.com/in/katelllegoulven/">Linked In</a></p></div>';
}

/** Customise the post info info function */
add_filter( 'genesis_post_info', 'genesischild_post_info' );
function genesischild_post_info($post_info) {
	if (!is_page()) {
 		$post_info = 'Posted on [post_date] [post_comments] [post_edit]';
 		return $post_info;
	}
}