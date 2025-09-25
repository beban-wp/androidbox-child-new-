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
            this.searchToggle = $('.beban-search-toggle');
            this.categoriesToggle = $('.beban-categories-toggle');
            this.searchClose = $('#beban-search-close');
            this.categoriesClose = $('#beban-categories-close');
            this.searchField = $('.beban-search-field');
            this.bottomBar = $('#beban-bottom-bar');
            this.cartCount = $('#beban-cart-count');
            this.cartLink = $('.beban-cart-link');
            
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
            
            
            // Close buttons
            this.categoriesClose.on('click', () => {
                this.closeCategories();
            });
            
            // Accordion menu functionality
            this.bindAccordionEvents();
            
            // Close on overlay click
            this.categoriesOverlay.on('click', (e) => {
                if (e.target === this.categoriesOverlay[0]) {
                    this.closeCategories();
                }
            });
            
            // Keyboard events
            $(document).on('keydown', (e) => {
                if (e.key === 'Escape') {
                    this.closeAllOverlays();
                }
            });
            
            // Cart count updates (WooCommerce)
            if (typeof wc_add_to_cart_params !== 'undefined') {
                $(document.body).on('added_to_cart', () => {
                    this.updateCartCount();
                });
                
                $(document.body).on('removed_from_cart', () => {
                    this.updateCartCount();
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
            this.categoriesOverlay.css('display', 'flex');
            // کمی تاخیر برای شروع انیمیشن
            setTimeout(() => {
                this.categoriesOverlay.addClass('active');
            }, 10);
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
            
            // بعد از اتمام انیمیشن، display را none کن
            setTimeout(() => {
                this.categoriesOverlay.css('display', 'none');
            }, 300);
            
            // Accessibility
            this.categoriesOverlay.attr('aria-hidden', 'true');
            this.categoriesToggle.attr('aria-expanded', 'false');
        }
        
        closeAllOverlays() {
            this.closeCategories();
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
                    url: wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'get_cart_count'),
                    type: 'POST',
                    success: (response) => {
                        if (response && response.fragments) {
                            this.cartCount.text(response.cart_count || 0);
                            
                            // Update cart count visibility
                            if (response.cart_count > 0) {
                                this.cartCount.show();
                            } else {
                                this.cartCount.hide();
                            }
                        }
                    },
                    error: () => {
                        // Fallback: try to get count from cart fragment
                        $.ajax({
                            url: wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'get_refreshed_fragments'),
                            type: 'POST',
                            success: (response) => {
                                if (response && response.fragments) {
                                    const cartCount = $(response.fragments['.beban-cart-count']).text();
                                    this.cartCount.text(cartCount || 0);
                                    
                                    if (cartCount > 0) {
                                        this.cartCount.show();
                                    } else {
                                        this.cartCount.hide();
                                    }
                                }
                            }
                        });
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
            
            this.categoriesToggle.attr({
                'role': 'button',
                'aria-expanded': 'false',
                'aria-controls': 'beban-categories-overlay'
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
