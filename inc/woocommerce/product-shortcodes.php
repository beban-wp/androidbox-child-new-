<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


// ---------------------------------------------------------------------------------------------------------------------------------------
// معرفی محصولات در مقالات
// ---------------------------------------------------------------------------------------------------------------------------------------
function beban_product_box_shortcode($atts) {
    $atts = shortcode_atts([
        'id' => '',
    ], $atts, 'product_box');

    $ids = array_map('trim', explode(',', $atts['id']));
    if (empty($ids)) return '';

    // ایجاد کلید کش یکتا
    $cache_key = 'beban_product_box_' . md5($atts['id']);
    
    // چک کردن کش موجود
    $cached_output = get_transient($cache_key);
    if ($cached_output !== false) {
        return $cached_output;
    }

    // تولید محتوا (در صورت عدم وجود کش)
    ob_start();
    echo '<div class="beban-custom-product-box-container">';

    foreach ($ids as $product_id) {
        // بررسی عددی بودن شناسه
        if (!is_numeric($product_id)) continue;
        
        $product = wc_get_product($product_id);
        if (!$product) continue;

        $image = wp_get_attachment_image_src($product->get_image_id(), 'medium')[0];
        // تصویر جایگزین در صورت عدم وجود
        if (!$image) {
            $image = wc_placeholder_img_src('medium');
        }
        
        $title = $product->get_name();
        $price = $product->get_price_html();
        $link = get_permalink($product_id);
        ?>

        <div class="beban-custom-product-box">
            <div class="beban-cpb-image">
                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>">
            </div>
            <div class="beban-cpb-content">
                <h3><?php echo esc_html($title); ?></h3>
                <div class="beban-cpb-price"><?php echo $price; ?></div>
                <a href="<?php echo esc_url($link); ?>" target="_blank" class="beban-cpb-button" aria-label="<?php echo esc_attr('مشاهده و خرید ' . $title); ?>">مشاهده و خرید کالا</a>
            </div>
        </div>

        <?php
    }

    echo '</div>';
    $output = ob_get_clean();
    
    // ذخیره در کش برای 30 دقیقه
    set_transient($cache_key, $output, 30 * MINUTE_IN_SECONDS);
    
    return $output;
}
add_shortcode('beban_product_box', 'beban_product_box_shortcode');

// پاک کردن کش هنگام تغییر محصولات
add_action('save_post', function($post_id) {
    if (get_post_type($post_id) === 'product') {
        // پاک کردن تمام کش‌های مربوط به شورت‌کد محصولات
        global $wpdb;
        $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_beban_product_box_%'");
    }
});

