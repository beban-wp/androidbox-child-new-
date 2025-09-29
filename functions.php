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

// Enqueue main JavaScript file for animations and utilities
// add_action('wp_enqueue_scripts', 'beban_enqueue_main_js');
// function beban_enqueue_main_js() {
//     wp_enqueue_script(
//         'beban-main-js',
//         get_stylesheet_directory_uri() . '/assets/js/main.js',
//         array('jquery'),
//         '1.0.0',
//         true
//     );
// }
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

// Include cart total shortcode
require_once get_stylesheet_directory() . '/inc/woocommerce/cart-total-shortcode.php';

// Include category post count shortcode
require_once get_stylesheet_directory() . '/inc/utils/category-post-count.php';

// Include floating social media buttons
require_once get_stylesheet_directory() . '/inc/utils/floating-social-buttons.php';

// Include professional bottom bar
require_once get_stylesheet_directory() . '/inc/utils/bottom-bar.php';

// Include back button component
require_once get_stylesheet_directory() . '/inc/utils/button-back.php';

// Register custom menu location for mobile menu
add_action('init', 'beban_register_mobile_menu');
function beban_register_mobile_menu() {
    register_nav_menus(array(
        'beban_mobile_menu' => __('منو موبایل', 'beban')
    ));
}

// Add bottom bar cart count to WooCommerce fragments
add_filter('woocommerce_add_to_cart_fragments', 'beban_add_to_cart_fragments');
function beban_add_to_cart_fragments($fragments) {
    $cart_count = WC()->cart->get_cart_contents_count();
    
    // Add our bottom bar cart count fragment
    $fragments['#beban-cart-count'] = '<span class="beban-cart-count" id="beban-cart-count">' . $cart_count . '</span>';
    
    // Add mini cart body fragment
    ob_start();
    beban_get_mini_cart_content();
    $mini_cart_content = ob_get_clean();
    $fragments['#beban-mini-cart-body'] = '<div class="beban-mini-cart-body" id="beban-mini-cart-body">' . $mini_cart_content . '</div>';
    
    return $fragments;
}

// Function to get mini cart content
function beban_get_mini_cart_content() {
    if (WC()->cart->is_empty()) : ?>
        <div class="beban-mini-cart-empty">
            <div class="beban-empty-cart-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.5 14.25C8.5 16.17 10.08 17.75 12 17.75C13.92 17.75 15.5 16.17 15.5 14.25" stroke="#ccc" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8.81 2L5.19 5.63" stroke="#ccc" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M15.19 2L18.81 5.63" stroke="#ccc" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2 7.84998C2 5.99998 2.99 5.84998 4.22 5.84998H19.78C21.01 5.84998 22 5.99998 22 7.84998C22 9.99998 21.01 9.84998 19.78 9.84998H4.22C2.99 9.84998 2 9.99998 2 7.84998Z" stroke="#ccc" stroke-width="1.5"/>
                    <path d="M3.5 10L4.91 18.64C5.23 20.58 6 22 8.86 22H14.89C18 22 18.46 20.64 18.82 18.76L20.5 10" stroke="#ccc" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </div>
            <p class="beban-empty-message">سبد خرید شما خالی است</p>
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="beban-continue-shopping">ادامه خرید</a>
        </div>
    <?php else : ?>
        <div class="beban-mini-cart-items">
            <?php
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                
                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) :
                    $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                    $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                    ?>
                    <div class="beban-mini-cart-item">
                        <div class="beban-item-image">
                            <a href="<?php echo esc_url($_product->get_permalink($cart_item)); ?>">
                                <?php echo $thumbnail; ?>
                            </a>
                        </div>
                        
                        <div class="beban-item-details">
                            <h4 class="beban-item-name">
                                <a href="<?php echo esc_url($_product->get_permalink($cart_item)); ?>">
                                    <?php echo wp_kses_post($product_name); ?>
                                </a>
                            </h4>
                            <div class="beban-item-meta">
                                <span class="beban-item-quantity"><?php echo $cart_item['quantity']; ?> ×</span>
                                <span class="beban-item-price"><?php echo $product_price; ?></span>
                            </div>
                        </div>
                        
                        <button class="beban-remove-item" data-cart_item_key="<?php echo esc_attr($cart_item_key); ?>" aria-label="حذف محصول">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13 13L1 1" stroke="#ff4444" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M1 13L13 1" stroke="#ff4444" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </button>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        
        <div class="beban-mini-cart-footer">
            <div class="beban-cart-total">
                <div class="beban-total-row">
                    <span class="beban-total-label">جمع کل:</span>
                    <span class="beban-total-amount"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
                </div>
            </div>
            
            <div class="beban-cart-actions">
                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="beban-view-cart-btn">سبد خرید</a>
                <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="beban-checkout-btn">پرداخت</a>
            </div>
        </div>
    <?php endif;
}
