<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Product Shortcodes for WooCommerce
 */

// ---------------------------------------------------------------------------------------------------------------------------------------
// معرفی محصولات در مقالات
// ---------------------------------------------------------------------------------------------------------------------------------------
function beban_product_box_shortcode($atts) {
    $atts = shortcode_atts([
        'id' => '',
    ], $atts, 'product_box');

    $ids = array_map('trim', explode(',', $atts['id']));
    if (empty($ids)) return '';

    ob_start();
    echo '<div class="custom-product-box-container">';

    foreach ($ids as $product_id) {
        $product = wc_get_product($product_id);
        if (!$product) continue;

        $image = wp_get_attachment_image_src($product->get_image_id(), 'medium')[0];
        $title = $product->get_name();
        $price = $product->get_price_html();
        $link = get_permalink($product_id);
        ?>

        <div class="custom-product-box">
            <div class="cpb-image">
                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>">
            </div>
            <div class="cpb-content">
                <h3><?php echo esc_html($title); ?></h3>
                <div class="cpb-price"><?php echo $price; ?></div>
                <a href="<?php echo esc_url($link); ?> " target="_blank" class="cpb-button">مشاهده و خرید کالا</a>
            </div>
        </div>

        <?php
    }

    echo '</div>';
    return ob_get_clean();
}
add_shortcode('beban_product_box', 'beban_product_box_shortcode');
