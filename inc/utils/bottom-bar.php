<?php
/**
 * Beban Bottom Bar
 * 
 * @package Beban Theme
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class BebanBottomBar {
    
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'beban_enqueue_scripts'));
        add_action('wp_footer', array($this, 'beban_render_bottom_bar'));
        add_action('wp_head', array($this, 'beban_add_responsive_meta'));
    }
    
    /**
     * Enqueue CSS and JavaScript files
     */
    public function beban_enqueue_scripts() {
        wp_enqueue_style('beban-bottom-bar', get_stylesheet_directory_uri() . '/assets/css/bottom-bar.css', array(), '1.0.0');
        wp_enqueue_script('beban-bottom-bar', get_stylesheet_directory_uri() . '/assets/js/bottom-bar.js', array('jquery'), '1.0.0', true);
    }
    
    /**
     * Add responsive meta tag for mobile
     */
    public function beban_add_responsive_meta() {
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    }
    
    /**
     * Check if bottom bar should be hidden
     */
    private function beban_should_hide_bottom_bar() {
        // مخفی کردن در صفحات سبد خرید، تسویه حساب، تشکر و پنل کاربری
        if (is_cart() || is_checkout() || is_wc_endpoint_url('order-received') || is_account_page()) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Render bottom bar HTML
     */
    public function beban_render_bottom_bar() {
        // بررسی اینکه آیا bottom bar باید مخفی باشد
        if ($this->beban_should_hide_bottom_bar()) {
            return;
        }
        ?>
        <div class="beban-bottom-nav" id="beban-bottom-bar">
            <ul class="beban-nav-list">
                <!-- Home Button -->
                <li class="beban-nav-item">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="beban-nav-link" aria-label="خانه">
                        <div class="beban-nav-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.02 2.84004L3.63 7.04004C2.73 7.74004 2 9.23004 2 10.36V17.77C2 20.09 3.89 21.99 6.21 21.99H17.79C20.11 21.99 22 20.09 22 17.78V10.5C22 9.29004 21.19 7.74004 20.2 7.05004L14.02 2.72004C12.62 1.74004 10.37 1.79004 9.02 2.84004Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 17.99V14.99" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span class="beban-nav-label">خانه</span>
                    </a>
                </li>
                
                <!-- Categories Button -->
                <li class="beban-nav-item">
                    <a href="#" class="beban-nav-link beban-categories-toggle" aria-label="دسته‌بندی‌ها">
                        <div class="beban-nav-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 10H7C9 10 10 9 10 7V5C10 3 9 2 7 2H5C3 2 2 3 2 5V7C2 9 3 10 5 10Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M17 10H19C21 10 22 9 22 7V5C22 3 21 2 19 2H17C15 2 14 3 14 5V7C14 9 15 10 17 10Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M17 22H19C21 22 22 21 22 19V17C22 15 21 14 19 14H17C15 14 14 15 14 17V19C14 21 15 22 17 22Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M5 22H7C9 22 10 21 10 19V17C10 15 9 14 7 14H5C3 14 2 15 2 17V19C2 21 3 22 5 22Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span class="beban-nav-label">دسته‌ها</span>
                    </a>
                </li>
                
                <!-- Center Cart Button (Floating) -->
                <li class="beban-nav-item beban-center-item">
                    <button class="beban-center-button beban-cart-toggle" role="button" aria-label="سبد خرید" aria-expanded="false">
                        <div class="beban-nav-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.5 14.25C8.5 16.17 10.08 17.75 12 17.75C13.92 17.75 15.5 16.17 15.5 14.25" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8.81 2L5.19 5.63" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M15.19 2L18.81 5.63" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M2 7.84998C2 5.99998 2.99 5.84998 4.22 5.84998H19.78C21.01 5.84998 22 5.99998 22 7.84998C22 9.99998 21.01 9.84998 19.78 9.84998H4.22C2.99 9.84998 2 9.99998 2 7.84998Z" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M3.5 10L4.91 18.64C5.23 20.58 6 22 8.86 22H14.89C18 22 18.46 20.64 18.82 18.76L20.5 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            <span class="beban-cart-count" id="beban-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                        </div>
                    </button>
                </li>
                
                <!-- Blog Button -->
                <li class="beban-nav-item">
                    <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="beban-nav-link" aria-label="وبلاگ">
                        <div class="beban-nav-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22 10V15C22 20 20 22 15 22H9C4 22 2 20 2 15V9C2 4 4 2 9 2H14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M22 10H18C15 10 14 9 14 6V2L22 10Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M7 13H13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M7 17H11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span class="beban-nav-label">وبلاگ</span>
                    </a>
                </li>
                
                <!-- Dashboard Button -->
                <li class="beban-nav-item">
                    <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="beban-nav-link" aria-label="داشبورد">
                        <div class="beban-nav-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 22V11" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M19 7V2" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 22V17" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 13V2" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M5 22V11" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M5 7V2" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M3 11H7" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M17 11H21" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M10 13H14" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span class="beban-nav-label">داشبورد</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Mini Cart -->
        <div id="beban-mini-cart" class="beban-mini-cart" aria-hidden="true">
            <div class="beban-mini-cart-overlay"></div>
            <div class="beban-mini-cart-content">
                <div class="beban-mini-cart-header">
                    <h3 class="beban-mini-cart-title">سبد خرید شما</h3>
                    <button class="beban-mini-cart-close" id="beban-mini-cart-close" aria-label="بستن سبد خرید">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 15L1 1" stroke="#3C3D45" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M1 15L15 1" stroke="#3C3D45" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
                
                <div class="beban-mini-cart-body" id="beban-mini-cart-body">
                    <?php if (WC()->cart->is_empty()) : ?>
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
                                            <?php if (empty($product_permalink)) : ?>
                                                <?php echo $thumbnail; ?>
                                            <?php else : ?>
                                                <a href="<?php echo esc_url($product_permalink); ?>">
                                                    <?php echo $thumbnail; ?>
                                                </a>
                                            <?php endif; ?>
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
                    <?php endif; ?>
                </div>
                
                <?php if (!WC()->cart->is_empty()) : ?>
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
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Categories Overlay -->
        <div id="beban-categories-overlay" class="beban-categories-overlay">
            <div class="beban-categories-overlay-content">
                <div class="beban-categories-header">
                    <div class="beban-categories-logo">
                        <img src="/wp-content/uploads/2025/08/android-box-dot-ir-text-logo-2023-modern-02-minimal.svg" alt="Android Box" />
                    </div>
                    <button class="beban-categories-close" id="beban-categories-close">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 15L1 1" stroke="#3C3D45" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M1 15L15 1" stroke="#3C3D45" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
                <div class="beban-categories-list">
                    <?php
                    // Display menu with accordion walker
                    if (has_nav_menu('beban_mobile_menu')) {
                        wp_nav_menu(array(
                            'theme_location' => 'beban_mobile_menu',
                            'container' => false,
                            'menu_class' => 'beban-accordion-menu',
                            'fallback_cb' => false,
                            'walker' => new Beban_Accordion_Walker(),
                            'depth' => 2
                        ));
                    } else {
                        // Fallback to product categories
                        $categories = get_terms(array(
                            'taxonomy' => 'product_cat',
                            'hide_empty' => true,
                            'parent' => 0
                        ));
                        
                        if (!empty($categories)) {
                            echo '<ul class="beban-accordion-menu">';
                            foreach ($categories as $category) {
                                echo '<li><a href="' . get_term_link($category) . '">' . $category->name . '</a></li>';
                            }
                            echo '</ul>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}


// Accordion Walker for Mobile Menu
class Beban_Accordion_Walker extends Walker_Nav_Menu {
    public $parent_url = '';
    public $parent_title = '';
    // شروع سطح (لیست ul)
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"beban-submenu-wrapper\" aria-hidden=\"true\">\n";
        $output .= "$indent\t<ul class=\"sub-menu\">\n";
    }

    // پایان سطح
    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        
        $output .= "$indent\t</ul>\n";
        
        // اگر زیرمنو است، لینک "همه" را اضافه کن
        if ($depth == 0) {
            $output .= "$indent\t<div class=\"beban-all-section\">";
            $output .= "<a href=\"" . $this->parent_url . "\" class=\"beban-all-link\">";
            $output .= "همه " . $this->parent_title;
            $output .= "<svg width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">";
            $output .= "<path d=\"M15 19.9201L8.47997 13.4001C7.70997 12.6301 7.70997 11.3701 8.47997 10.6001L15 4.08008\" stroke=\"#007BFF\" stroke-width=\"1.5\" stroke-miterlimit=\"10\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>";
            $output .= "</svg>";
            $output .= "</a>";
            $output .= "</div>\n";
        }
        
        $output .= "$indent</div>\n";
    }

    // شروع آیتم (li)
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // اضافه کردن کلاس برای آیتم‌های والد
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'has-sub-menu';
            // ذخیره اطلاعات parent برای لینک "همه"
            $this->parent_url = $item->url;
            $this->parent_title = $item->title;
        }

        // اضافه کردن کلاس برای آیتم فعال
        if (in_array('current-menu-item', $classes) || in_array('current-menu-parent', $classes)) {
            $classes[] = 'active';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= $indent . '<li' . $class_names . '>';

        $atts = array();
        $atts['title'] = !empty($item->title) ? $item->title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
        $atts['href'] = !empty($item->url) ? $item->url : '';

        // اضافه کردن ویژگی‌های ARIA برای دسترسی‌پذیری
        if (in_array('menu-item-has-children', $classes)) {
            $atts['aria-expanded'] = 'false';
            $atts['aria-haspopup'] = 'true';
        }

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        
        // اضافه کردن آیکون برای آیتم‌های دارای زیرمنو
        if (in_array('menu-item-has-children', $classes)) {
            $item_output .= '<svg class="beban-arrow-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">';
            $item_output .= '<path d="M19.9201 8.94995L13.4001 15.47C12.6301 16.24 11.3701 16.24 10.6001 15.47L4.08008 8.94995" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>';
            $item_output .= '</svg>';
        }
        
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    // پایان آیتم
    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}

// Initialize the class
new BebanBottomBar();
