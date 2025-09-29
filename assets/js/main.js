/**
 * Main JavaScript file for small utilities and animations
 * شامل کدهای کوچک و انیمیشن‌های مختلف
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // انیمیشن لودینگ برای دکمه checkout
    initCheckoutButtonAnimation();
    
    // انیمیشن لودینگ برای دکمه view cart
    initViewCartButtonAnimation();
    
    // انیمیشن لودینگ برای دکمه go checkout
    initGoCheckoutButtonAnimation();
    
    // اجرای مجدد برای دکمه‌هایی که بعداً اضافه می‌شوند
    setTimeout(() => {
        initViewCartButtonAnimation();
        initGoCheckoutButtonAnimation();
    }, 1000);
    
    // اجرای مجدد برای دکمه‌هایی که بعداً اضافه می‌شوند
    setTimeout(() => {
        initViewCartButtonAnimation();
        initGoCheckoutButtonAnimation();
    }, 3000);
    
    // سایر کدهای کوچک اینجا اضافه می‌شوند
});

/**
 * انیمیشن لودینگ برای دکمه checkout
 */
function initCheckoutButtonAnimation() {
    // پیدا کردن دکمه checkout
    const checkoutButton = document.querySelector('.checkout-button');
    
    if (checkoutButton) {
        // اضافه کردن event listener برای کلیک
        checkoutButton.addEventListener('click', function(e) {
            // اضافه کردن کلاس loading
            this.classList.add('loading');
            
            // بررسی اینکه آیا دکمه لینک است یا نه
            const href = this.getAttribute('href');
            const isLink = href && href !== '#' && !href.startsWith('javascript:');
            
            if (isLink) {
                // اگر لینک است، انیمیشن را تا زمان بارگذاری صفحه نگه دار
                // انیمیشن خودکار متوقف نمی‌شود چون صفحه تغییر می‌کند
                return;
            } else {
                // اگر لینک نیست، شبیه‌سازی فرآیند (در واقعیت اینجا AJAX call می‌شود)
                setTimeout(() => {
                    // حذف کلاس loading وقتی پاسخ از سرور آمد
                    this.classList.remove('loading');
                }, 1500); // شبیه‌سازی زمان لودینگ
            }
        });
    }
}

/**
 * انیمیشن لودینگ برای دکمه view cart
 */
function initViewCartButtonAnimation() {
    // پیدا کردن دکمه‌های view cart
    const viewCartButtons = document.querySelectorAll('.elementor-button--view-cart');
    
    viewCartButtons.forEach(button => {
        // اضافه کردن event listener برای کلیک
        button.addEventListener('click', function(e) {
            // اضافه کردن کلاس loading
            this.classList.add('loading');
            
            // بررسی اینکه آیا دکمه لینک است یا نه
            const href = this.getAttribute('href');
            const isLink = href && href !== '#' && !href.startsWith('javascript:');
            
            if (isLink) {
                // اگر لینک است، انیمیشن را تا زمان بارگذاری صفحه نگه دار
                // انیمیشن خودکار متوقف نمی‌شود چون صفحه تغییر می‌کند
                return;
            } else {
                // اگر لینک نیست، شبیه‌سازی فرآیند (در واقعیت اینجا AJAX call می‌شود)
                setTimeout(() => {
                    // حذف کلاس loading وقتی پاسخ از سرور آمد
                    this.classList.remove('loading');
                }, 1500);
            }
        });
    });
}

/**
 * انیمیشن لودینگ برای دکمه go checkout
 */
function initGoCheckoutButtonAnimation() {
    // پیدا کردن دکمه‌های go checkout
    const goCheckoutButtons = document.querySelectorAll('.beban-go-checkout .elementor-button');
    
    goCheckoutButtons.forEach(button => {
        // اضافه کردن event listener برای کلیک
        button.addEventListener('click', function(e) {
            // اضافه کردن کلاس loading
            this.classList.add('loading');
            
            // بررسی اینکه آیا دکمه لینک است یا نه
            const href = this.getAttribute('href');
            const isLink = href && href !== '#' && !href.startsWith('javascript:');
            
            if (isLink) {
                // اگر لینک است، انیمیشن را تا زمان بارگذاری صفحه نگه دار
                // انیمیشن خودکار متوقف نمی‌شود چون صفحه تغییر می‌کند
                return;
            } else {
                // اگر لینک نیست، شبیه‌سازی فرآیند (در واقعیت اینجا AJAX call می‌شود)
                setTimeout(() => {
                    // حذف کلاس loading وقتی پاسخ از سرور آمد
                    this.classList.remove('loading');
                }, 1500);
            }
        });
    });
}

/**
 * تابع کمکی برای اضافه کردن انیمیشن به هر دکمه
 * @param {string} selector - انتخابگر CSS دکمه
 * @param {number} loadingTime - زمان لودینگ به میلی‌ثانیه
 */
function addButtonAnimation(selector, loadingTime = 1500) {
    const button = document.querySelector(selector);
    
    if (button) {
        button.addEventListener('click', function(e) {
            // اضافه کردن کلاس loading
            this.classList.add('loading');
            
            // بررسی اینکه آیا دکمه لینک است یا نه
            const href = this.getAttribute('href');
            const isLink = href && href !== '#' && !href.startsWith('javascript:');
            
            if (isLink) {
                // اگر لینک است، انیمیشن را تا زمان بارگذاری صفحه نگه دار
                // انیمیشن خودکار متوقف نمی‌شود چون صفحه تغییر می‌کند
                return;
            } else {
                // اگر لینک نیست، شبیه‌سازی فرآیند (در واقعیت اینجا AJAX call می‌شود)
                setTimeout(() => {
                    // حذف کلاس loading وقتی پاسخ از سرور آمد
                    this.classList.remove('loading');
                }, loadingTime);
            }
        });
    }
}

/**
 * تابع برای انیمیشن دکمه‌های افزودن به سبد خرید
 */
function initAddToCartAnimation() {
    const addToCartButtons = document.querySelectorAll('.single_add_to_cart_button');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // اضافه کردن کلاس loading
            this.classList.add('loading');
            
            // بررسی اینکه آیا دکمه لینک است یا نه
            const href = this.getAttribute('href');
            const isLink = href && href !== '#' && !href.startsWith('javascript:');
            
            if (isLink) {
                // اگر لینک است، انیمیشن را تا زمان بارگذاری صفحه نگه دار
                // انیمیشن خودکار متوقف نمی‌شود چون صفحه تغییر می‌کند
                return;
            } else {
                // اگر لینک نیست، شبیه‌سازی فرآیند افزودن به سبد خرید (در واقعیت اینجا AJAX call می‌شود)
                setTimeout(() => {
                    // حذف کلاس loading وقتی پاسخ از سرور آمد
                    this.classList.remove('loading');
                }, 1500);
            }
        });
    });
}

// راه‌اندازی انیمیشن دکمه‌های افزودن به سبد خرید
initAddToCartAnimation();
