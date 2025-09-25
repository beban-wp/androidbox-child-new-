<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'hello-elementor','hello-elementor-theme-style','hello-elementor-header-footer' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

// END ENQUEUE PARENT ACTION

// Include custom WooCommerce features
require_once get_stylesheet_directory() . '/inc/woocommerce/account-navigation.php';
require_once get_stylesheet_directory() . '/inc/woocommerce/checkout-fields.php';
require_once get_stylesheet_directory() . '/inc/woocommerce/orders-history.php';
require_once get_stylesheet_directory() . '/inc/woocommerce/product-shortcodes.php';
require_once get_stylesheet_directory() . '/inc/woocommerce/product-rating.php';
require_once get_stylesheet_directory() . '/inc/woocommerce/category-count.php';
require_once get_stylesheet_directory() . '/inc/woocommerce/product-filters.php';
require_once get_stylesheet_directory() . '/inc/woocommerce/carousel-features.php';
require_once get_stylesheet_directory() . '/inc/woocommerce/stock-notice.php';
require_once get_stylesheet_directory() . '/inc/woocommerce/cart-features.php';
require_once get_stylesheet_directory() . '/inc/woocommerce/order-received.php';
require_once get_stylesheet_directory() . '/inc/woocommerce/related-products.php';

// Enqueue product reviews JavaScript only on product pages
add_action('wp_enqueue_scripts', 'beban_enqueue_product_reviews_js');
function beban_enqueue_product_reviews_js() {
    if (is_product()) {
        wp_enqueue_script(
            'beban-product-reviews',
            get_stylesheet_directory_uri() . '/assets/js/product-reviews.js',
            array('jquery'),
            '1.0.0',
            true
        );
    }
    
}
require_once get_stylesheet_directory() . '/inc/woocommerce/product-reviews.php';
require_once get_stylesheet_directory() . '/inc/utils/gallery-optimization.php';

require_once get_stylesheet_directory() . '/inc/utils/post-comments.php';

// Include performance optimizations
require_once get_stylesheet_directory() . '/inc/utils/remove-jquery-migrate.php';

// Include latest orders shortcode
require_once get_stylesheet_directory() . '/inc/woocommerce/list-latest-orders.php';

// Include suggested products dashboard
require_once get_stylesheet_directory() . '/inc/woocommerce/suggested-products-dashboard.php';

require_once get_stylesheet_directory() . '/inc/woocommerce/my-reviews.php';

// Include stock sorting feature
require_once get_stylesheet_directory() . '/inc/woocommerce/stock-sorting.php';

// Include category post count shortcode
require_once get_stylesheet_directory() . '/inc/utils/category-post-count.php';

// Include floating social media buttons
require_once get_stylesheet_directory() . '/inc/utils/floating-social-buttons.php';

// Include professional bottom bar
require_once get_stylesheet_directory() . '/inc/utils/bottom-bar.php';

// Register custom menu location for mobile menu
add_action('init', 'beban_register_mobile_menu');
function beban_register_mobile_menu() {
    register_nav_menus(array(
        'beban_mobile_menu' => __('منو موبایل', 'beban')
    ));
}
