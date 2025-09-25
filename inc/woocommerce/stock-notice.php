<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Stock Notice for WooCommerce
 */

// ---------------------------------------------------------------------------------------------------------------------------------------
// نمایش وضعیت موجودی محصولات WooCommerce
// حالت‌های مختلف:
// 1- موجود با تعداد مشخص: "۵ عدد موجود" یا "تنها ۲ عدد موجود" (اگر زیر ۳ تا)
// 2- موجود بدون تعداد: "موجودی زیاد"
// 3- ناموجود: هیچ چیزی نشون نده
// ---------------------------------------------------------------------------------------------------------------------------------------
add_shortcode( 'beban_stock_notice', 'beban_stock_notice_shortcode' );
function beban_stock_notice_shortcode() {
    global $product;
    
    // بررسی اینکه آیا در صفحه محصول هستیم و محصول وجود داره
    if ( ! $product || ! is_a( $product, 'WC_Product' ) ) {
        return '';
    }
    
    // بررسی وضعیت موجودی محصول
    $stock_status = $product->get_stock_status();
    $stock_quantity = $product->get_stock_quantity();
    
    // حالت ۲: اگر موجود نبود، هیچ چیزی نشون نده
    if ( $stock_status === 'outofstock' ) {
        return '';
    }
    
    // حالت ۳: اگر موجود بود و موجودی مشخص نشده بود
    if ( $stock_status === 'instock' && ! $product->managing_stock() ) {
        return '<span class="beban-stock-notice">موجودی زیاد</span>';
    }
    
    // حالت ۱: اگر موجود بود و موجودی مشخص شده بود
    if ( $product->managing_stock() && $stock_quantity > 0 ) {
        $quantity_text = esc_html( $stock_quantity ) . ' عدد موجود';
        
        // اگر زیر ۲ تا رسید، "تنها" اضافه کن
        if ( $stock_quantity <= 2 ) {
            $quantity_text = 'تنها ' . $quantity_text;
        }
        
        return '<span class="beban-stock-notice">' . $quantity_text . '</span>';
    }
    
    return '';
}
