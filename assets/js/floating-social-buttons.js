/**
 * Floating Social Media Buttons JavaScript
 * 
 * @package AndroidBox Child Theme
 * @since 1.0.0
 */

(function($) {
    'use strict';
    
    class FloatingSocialButtons {
        constructor() {
            this.mainButton = $('#social-main-btn');
            this.wrapper = $('#social-buttons-wrapper');
            this.isOpen = false;
            this.autoHideTimer = null;
            this.init();
        }
        
        init() {
            this.bindEvents();
            this.setupAccessibility();
        }
        
        bindEvents() {
            // Main button click
            this.mainButton.on('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.toggleButtons();
            });
            
            // Click outside to close
            $(document).on('click', (e) => {
                if (this.isOpen && !$(e.target).closest('.floating-social-container').length) {
                    this.closeButtons();
                }
            });
            
            // Keyboard navigation
            $(document).on('keydown', (e) => {
                if (e.key === 'Escape' && this.isOpen) {
                    this.closeButtons();
                }
            });
            
            // Social button hover effects
            $('.social-btn').on('mouseenter', function() {
                $(this).addClass('hover-effect');
            }).on('mouseleave', function() {
                $(this).removeClass('hover-effect');
            });
            
            // Touch events for mobile
            this.mainButton.on('touchstart', (e) => {
                e.preventDefault();
                this.mainButton.addClass('touch-active');
            });
            
            this.mainButton.on('touchend', (e) => {
                e.preventDefault();
                this.mainButton.removeClass('touch-active');
                this.toggleButtons();
            });
        }
        
        toggleButtons() {
            if (this.isOpen) {
                this.closeButtons();
            } else {
                this.openButtons();
            }
        }
        
        openButtons() {
            this.isOpen = true;
            
            // Add active classes
            this.mainButton.addClass('active');
            this.wrapper.addClass('active');
            
            // Auto-hide disabled as per user request
            // this.startAutoHideTimer();
            
            // Add body class for potential global styles
            $('body').addClass('social-buttons-open');
            
            // Analytics tracking (if available)
            if (typeof gtag !== 'undefined') {
                gtag('event', 'social_buttons_open', {
                    'event_category': 'engagement',
                    'event_label': 'floating_social_buttons'
                });
            }
            
            // Accessibility
            this.wrapper.attr('aria-hidden', 'false');
            this.mainButton.attr('aria-expanded', 'true');
            
            // Focus management
            this.wrapper.find('.social-btn').first().focus();
        }
        
        closeButtons() {
            this.isOpen = false;
            
            // Remove active classes
            this.mainButton.removeClass('active');
            this.wrapper.removeClass('active');
            
            // Auto-hide timer disabled as per user request
            // this.clearAutoHideTimer();
            
            // Remove body class
            $('body').removeClass('social-buttons-open');
            
            // Accessibility
            this.wrapper.attr('aria-hidden', 'true');
            this.mainButton.attr('aria-expanded', 'false');
            
            // Return focus to main button
            this.mainButton.focus();
        }
        
        startAutoHideTimer() {
            this.clearAutoHideTimer();
            this.autoHideTimer = setTimeout(() => {
                if (this.isOpen) {
                    this.closeButtons();
                }
            }, 5000); // Auto-hide after 5 seconds
        }
        
        clearAutoHideTimer() {
            if (this.autoHideTimer) {
                clearTimeout(this.autoHideTimer);
                this.autoHideTimer = null;
            }
        }
        
        setupAccessibility() {
            // Set initial ARIA attributes
            this.mainButton.attr({
                'role': 'button',
                'aria-label': 'Open social media links',
                'aria-expanded': 'false',
                'tabindex': '0'
            });
            
            this.wrapper.attr({
                'role': 'menu',
                'aria-label': 'Social media links',
                'aria-hidden': 'true'
            });
            
            // Set ARIA attributes for social buttons
            $('.social-btn').each(function() {
                $(this).attr({
                    'role': 'menuitem',
                    'tabindex': '-1'
                });
            });
            
            // Keyboard navigation for social buttons
            $('.social-btn').on('keydown', function(e) {
                const buttons = $('.social-btn');
                const currentIndex = buttons.index(this);
                
                switch(e.key) {
                    case 'ArrowDown':
                        e.preventDefault();
                        const nextIndex = (currentIndex + 1) % buttons.length;
                        buttons.eq(nextIndex).focus();
                        break;
                    case 'ArrowUp':
                        e.preventDefault();
                        const prevIndex = currentIndex === 0 ? buttons.length - 1 : currentIndex - 1;
                        buttons.eq(prevIndex).focus();
                        break;
                    case 'Enter':
                    case ' ':
                        e.preventDefault();
                        $(this)[0].click();
                        break;
                }
            });
        }
        
        // Public method to update social links dynamically
        updateSocialLinks(links) {
            if (links.whatsapp) {
                $('.whatsapp-btn').attr('href', links.whatsapp);
            }
            if (links.telegram) {
                $('.telegram-btn').attr('href', links.telegram);
            }
            if (links.instagram) {
                $('.instagram-btn').attr('href', links.instagram);
            }
        }
        
        // Public method to refresh social links from server
        refreshSocialLinks() {
            if (typeof socialButtons !== 'undefined') {
                $.ajax({
                    url: socialButtons.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'get_social_links',
                        nonce: socialButtons.nonce
                    },
                    success: (response) => {
                        if (response.success) {
                            this.updateSocialLinks(response.data);
                        }
                    },
                    error: (xhr, status, error) => {
                        console.error('Failed to refresh social links:', error);
                    }
                });
            }
        }
    }
    
    // Initialize when document is ready
    $(document).ready(function() {
        // Only initialize if the elements exist
        if ($('#floating-social-buttons').length) {
            window.floatingSocialButtons = new FloatingSocialButtons();
        }
    });
    
    // Expose for external use
    window.FloatingSocialButtons = FloatingSocialButtons;
    
})(jQuery);
