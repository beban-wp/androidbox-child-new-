/**
 * Beban Bottom Bar JavaScript
 * 
 * @package Beban Theme
 * @since 1.0.0
 */

(function($) {
    'use strict';
    
    class BebanBottomBar {
        constructor() {
            this.searchOverlay = $('#beban-search-overlay');
            this.categoriesOverlay = $('#beban-categories-overlay');
            this.miniCart = $('#beban-mini-cart');
            this.searchToggle = $('.beban-search-toggle');
            this.categoriesToggle = $('.beban-categories-toggle');
            this.cartToggle = $('.beban-cart-toggle');
            this.searchClose = $('#beban-search-close');
            this.categoriesClose = $('#beban-categories-close');
            this.miniCartClose = $('#beban-mini-cart-close');
            this.searchField = $('.beban-search-field');
            this.bottomBar = $('#beban-bottom-bar');
            this.cartCount = $('#beban-cart-count');
            this.cartLink = $('.beban-cart-link');
            this.miniCartBody = $('#beban-mini-cart-body');
            
            this.init();
        }
        
        init() {
            this.bindEvents();
            this.updateCartCount();
            this.checkVisibility();
            this.setupAccessibility();
            this.highlightActivePage();
        }
        
        bindEvents() {
            // Categories toggle
            this.categoriesToggle.on('click', (e) => {
                e.preventDefault();
                this.openCategories();
            });
            
            // Cart toggle
            this.cartToggle.on('click', (e) => {
                e.preventDefault();
                this.openMiniCart();
            });
            
            // Close buttons
            this.categoriesClose.on('click', () => {
                this.closeCategories();
            });
            
            this.miniCartClose.on('click', () => {
                this.closeMiniCart();
            });
            
            // Accordion menu functionality
            this.bindAccordionEvents();
            
            // Close on overlay click
            this.categoriesOverlay.on('click', (e) => {
                if (e.target === this.categoriesOverlay[0]) {
                    this.closeCategories();
                }
            });
            
            this.miniCart.find('.beban-mini-cart-overlay').on('click', () => {
                this.closeMiniCart();
            });
            
            // Remove item from cart
            $(document).on('click', '.beban-remove-item', (e) => {
                e.preventDefault();
                const cartItemKey = $(e.currentTarget).data('cart_item_key');
                this.removeCartItem(cartItemKey);
            });
            
            // Keyboard events
            $(document).on('keydown', (e) => {
                if (e.key === 'Escape') {
                    this.closeAllOverlays();
                }
            });
            
            // Cart count updates (WooCommerce)
            if (typeof wc_add_to_cart_params !== 'undefined') {
                $(document.body).on('added_to_cart', (event, fragments, cart_hash, button) => {
                    this.updateCartCountFromFragments(fragments);
                    this.updateMiniCartContent(fragments);
                });
                
                $(document.body).on('removed_from_cart', (event, fragments) => {
                    this.updateCartCountFromFragments(fragments);
                    this.updateMiniCartContent(fragments);
                });
                
                // Listen for WooCommerce AJAX cart updates
                $(document.body).on('wc_fragments_refreshed', (event, fragments) => {
                    this.updateCartCountFromFragments(fragments);
                    this.updateMiniCartContent(fragments);
                });
                
                // Listen for cart updates from other sources
                $(document.body).on('wc_cart_fragments_refreshed', (event, fragments) => {
                    this.updateCartCountFromFragments(fragments);
                    this.updateMiniCartContent(fragments);
                });
            }
            
            // Window resize
            $(window).on('resize', () => {
                this.checkVisibility();
            });
            
            // Scroll events for better UX
            let lastScrollTop = 0;
            $(window).on('scroll', () => {
                const scrollTop = $(this).scrollTop();
                
                // Hide bottom bar when scrolling down (optional)
                if (scrollTop > lastScrollTop && scrollTop > 100) {
                    this.bottomBar.addClass('beban-scrolled-down');
                } else {
                    this.bottomBar.removeClass('beban-scrolled-down');
                }
                
                lastScrollTop = scrollTop;
            });
            
            // Touch events for mobile
            this.bottomBar.on('touchstart', (e) => {
                $(e.target).closest('.beban-nav-link, .beban-center-button').addClass('beban-touch-active');
            });
            
            this.bottomBar.on('touchend', (e) => {
                $(e.target).closest('.beban-nav-link, .beban-center-button').removeClass('beban-touch-active');
            });
        }
        
        
        openCategories() {
            this.categoriesOverlay.addClass('active');
            $('body').addClass('beban-overlay-open');
            
            // Analytics tracking
            if (typeof gtag !== 'undefined') {
                gtag('event', 'categories_opened', {
                    'event_category': 'beban_bottom_bar',
                    'event_label': 'categories_overlay'
                });
            }
            
            // Accessibility
            this.categoriesOverlay.attr('aria-hidden', 'false');
            this.categoriesToggle.attr('aria-expanded', 'true');
        }
        
        closeCategories() {
            this.categoriesOverlay.removeClass('active');
            $('body').removeClass('beban-overlay-open');
            
            // Accessibility
            this.categoriesOverlay.attr('aria-hidden', 'true');
            this.categoriesToggle.attr('aria-expanded', 'false');
        }
        
        openMiniCart() {
            this.miniCart.addClass('active');
            $('body').addClass('beban-overlay-open');
            
            // Close other overlays
            this.closeCategories();
            
            // Analytics tracking
            if (typeof gtag !== 'undefined') {
                gtag('event', 'mini_cart_opened', {
                    'event_category': 'beban_bottom_bar',
                    'event_label': 'mini_cart'
                });
            }
            
            // Accessibility
            this.miniCart.attr('aria-hidden', 'false');
            this.cartToggle.attr('aria-expanded', 'true');
        }
        
        closeMiniCart() {
            this.miniCart.removeClass('active');
            $('body').removeClass('beban-overlay-open');
            
            // Accessibility
            this.miniCart.attr('aria-hidden', 'true');
            this.cartToggle.attr('aria-expanded', 'false');
        }
        
        closeAllOverlays() {
            this.closeCategories();
            this.closeMiniCart();
        }
        
        bindAccordionEvents() {
            // کلیک روی آیتم‌های والد
            $(document).on('click', '.beban-accordion-menu li.menu-item-has-children > a', (e) => {
                e.preventDefault();

                const $parent = $(e.currentTarget).parent();
                const $subMenuWrapper = $parent.find('> .beban-submenu-wrapper');
                const isExpanded = $parent.hasClass('active');

                // بستن سایر زیرمنوها
                $('.beban-accordion-menu li.menu-item-has-children.active').not($parent).removeClass('active').find('> .beban-submenu-wrapper').attr('aria-hidden', 'true');
                $('.beban-accordion-menu li.menu-item-has-children.active').not($parent).find('> a').attr('aria-expanded', 'false');

                // باز یا بسته کردن زیرمنوی فعلی
                $parent.toggleClass('active');
                $subMenuWrapper.attr('aria-hidden', isExpanded ? 'true' : 'false');
                $(e.currentTarget).attr('aria-expanded', isExpanded ? 'false' : 'true');
            });
        }
        
        updateCartCount() {
            if (typeof wc_add_to_cart_params !== 'undefined') {
                $.ajax({
                    url: wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'get_refreshed_fragments'),
                    type: 'POST',
                    success: (response) => {
                        if (response && response.fragments) {
                            this.updateCartCountFromFragments(response.fragments);
                        }
                    },
                    error: (xhr, status, error) => {
                        console.log('Cart count update failed:', error);
                    }
                });
            }
        }
        
        updateCartCountFromFragments(fragments) {
            if (!fragments) return;
            
            console.log('Bottom Bar: Updating cart count from fragments', fragments);
            
            // Try to get cart count from different possible fragment selectors
            let cartCount = 0;
            
            // Check for elementor cart count fragment
            if (fragments['.elementor-menu-cart__toggle_button span.elementor-button-icon-qty']) {
                const qtyElement = $(fragments['.elementor-menu-cart__toggle_button span.elementor-button-icon-qty']);
                cartCount = parseInt(qtyElement.attr('data-counter') || qtyElement.text()) || 0;
            }
            // Check for WooCommerce mini cart count
            else if (fragments['a.cart-contents .count']) {
                cartCount = parseInt($(fragments['a.cart-contents .count']).text()) || 0;
            }
            // Check for our specific bottom bar cart count
            else if (fragments['.beban-cart-count'] || fragments['#beban-cart-count']) {
                const fragment = fragments['.beban-cart-count'] || fragments['#beban-cart-count'];
                cartCount = parseInt($(fragment).text()) || 0;
            }
            // Try to extract from cart contents
            else if (fragments['div.widget_shopping_cart_content'] || fragments['.widget_shopping_cart_content']) {
                const cartContent = fragments['div.widget_shopping_cart_content'] || fragments['.widget_shopping_cart_content'];
                const matches = cartContent.match(/data-counter[="](\d+)/);
                if (matches) {
                    cartCount = parseInt(matches[1]) || 0;
                } else {
                    // Count product quantities in cart
                    const $cartContent = $(cartContent);
                    let totalCount = 0;
                    $cartContent.find('.product-quantity').each(function() {
                        const qty = parseInt($(this).text().replace('×', '').trim()) || 0;
                        totalCount += qty;
                    });
                    cartCount = totalCount;
                }
            }
            
            // Update our bottom bar cart count
            console.log('Bottom Bar: Setting cart count to', cartCount);
            this.cartCount.text(cartCount);
            
            // Update cart count visibility
            if (cartCount > 0) {
                this.cartCount.show().addClass('beban-has-items');
            } else {
                this.cartCount.hide().removeClass('beban-has-items');
            }
            
            // Add animation effect
            this.cartCount.addClass('beban-updated');
            setTimeout(() => {
                this.cartCount.removeClass('beban-updated');
            }, 300);
        }
        
        removeCartItem(cartItemKey) {
            if (typeof wc_add_to_cart_params !== 'undefined') {
                // Show loading state
                const removeButton = $(`.beban-remove-item[data-cart_item_key="${cartItemKey}"]`);
                removeButton.addClass('loading').prop('disabled', true);
                
                $.ajax({
                    url: wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'remove_from_cart'),
                    type: 'POST',
                    data: {
                        cart_item_key: cartItemKey
                    },
                    success: (response) => {
                        if (response && response.fragments) {
                            // Update cart fragments
                            this.updateCartCountFromFragments(response.fragments);
                            this.updateMiniCartContent(response.fragments);
                        }
                    },
                    error: () => {
                        // Remove loading state
                        removeButton.removeClass('loading').prop('disabled', false);
                        console.log('Failed to remove item from cart');
                    }
                });
            }
        }
        
        updateMiniCartContent(fragments) {
            // Update mini cart content if fragment exists
            if (fragments && fragments['#beban-mini-cart-body']) {
                this.miniCartBody.html($(fragments['#beban-mini-cart-body']).html());
            } else {
                // Fallback: refresh mini cart via AJAX
                this.refreshMiniCart();
            }
        }
        
        refreshMiniCart() {
            if (typeof wc_add_to_cart_params !== 'undefined') {
                $.ajax({
                    url: wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'get_refreshed_fragments'),
                    type: 'POST',
                    success: (response) => {
                        if (response && response.fragments) {
                            this.updateMiniCartContent(response.fragments);
                            this.updateCartCountFromFragments(response.fragments);
                        }
                    }
                });
            }
        }
        
        checkVisibility() {
            const windowWidth = $(window).width();
            
            if (windowWidth <= 991) {
                this.bottomBar.show().addClass('beban-fade-in');
                $('body').addClass('beban-has-bottom-bar');
            } else {
                this.bottomBar.hide().removeClass('beban-fade-in');
                $('body').removeClass('beban-has-bottom-bar');
                this.closeAllOverlays();
            }
        }
        
        setupAccessibility() {
            // Set initial ARIA attributes
            this.categoriesOverlay.attr({
                'role': 'dialog',
                'aria-label': 'دسته‌بندی‌ها',
                'aria-hidden': 'true'
            });
            
            this.miniCart.attr({
                'role': 'dialog',
                'aria-label': 'سبد خرید',
                'aria-hidden': 'true'
            });
            
            this.categoriesToggle.attr({
                'role': 'button',
                'aria-expanded': 'false',
                'aria-controls': 'beban-categories-overlay'
            });
            
            this.cartToggle.attr({
                'role': 'button',
                'aria-expanded': 'false',
                'aria-controls': 'beban-mini-cart'
            });
            
            // Focus management
            this.bottomBar.find('.beban-nav-link, .beban-center-button').each(function() {
                $(this).attr('tabindex', '0');
            });
        }
        
        // Public method to refresh cart count
        refreshCartCount() {
            this.updateCartCount();
        }
        
        
        // Public method to highlight active page
        highlightActivePage() {
            const currentUrl = window.location.pathname;
            const homeUrl = '/';
            
            this.bottomBar.find('.beban-nav-link').each(function() {
                const link = $(this);
                const href = link.attr('href');
                
                if (href === currentUrl || (currentUrl === homeUrl && href.includes(homeUrl))) {
                    link.addClass('active');
                } else {
                    link.removeClass('active');
                }
            });
        }
        
        // Public method to show/hide bottom bar
        showBottomBar() {
            this.bottomBar.show().addClass('beban-fade-in');
        }
        
        hideBottomBar() {
            this.bottomBar.hide().removeClass('beban-fade-in');
        }
    }
    
    // Initialize when document is ready
    $(document).ready(function() {
        // Only initialize if the bottom bar exists
        if ($('#beban-bottom-bar').length) {
            window.bebanBottomBar = new BebanBottomBar();
            
            // Highlight active page after initialization
            setTimeout(() => {
                window.bebanBottomBar.highlightActivePage();
            }, 100);
        }
    });
    
    // Expose for external use
    window.BebanBottomBar = BebanBottomBar;
    
})(jQuery);