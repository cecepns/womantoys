/**
 * Shopping Cart Management with LocalStorage
 * WomanToys E-commerce
 */

const CartManager = {
    // Key untuk localStorage
    STORAGE_KEY: 'womantoys_cart',

    /**
     * Mendapatkan semua item di keranjang
     * @returns {Array} Array of cart items
     */
    getCartItems() {
        try {
            const cartData = localStorage.getItem(this.STORAGE_KEY);
            return cartData ? JSON.parse(cartData) : [];
        } catch (error) {
            console.error('Error reading cart from localStorage:', error);
            return [];
        }
    },

    /**
     * Menyimpan cart items ke localStorage
     * @param {Array} items - Cart items to save
     */
    saveCartItems(items) {
        try {
            localStorage.setItem(this.STORAGE_KEY, JSON.stringify(items));
            this.updateCartBadge();
            this.dispatchCartUpdateEvent();
        } catch (error) {
            console.error('Error saving cart to localStorage:', error);
        }
    },

    /**
     * Menambahkan produk ke keranjang
     * @param {Object} product - Product data
     * @returns {boolean} Success status
     */
    addToCart(product) {
        try {
            const cart = this.getCartItems();
            
            // Validasi data produk
            if (!product.id || !product.name || !product.price) {
                console.error('Invalid product data');
                return false;
            }

            // Generate unique ID untuk cart item
            const cartItemId = product.variantId 
                ? `${product.id}-${product.variantId}` 
                : `${product.id}`;

            // Cek apakah item sudah ada di cart
            const existingItemIndex = cart.findIndex(item => item.cartItemId === cartItemId);

            if (existingItemIndex > -1) {
                // Item sudah ada, update quantity
                cart[existingItemIndex].quantity += product.quantity || 1;
            } else {
                // Item baru, tambahkan ke cart
                const cartItem = {
                    cartItemId: cartItemId,
                    id: product.id,
                    variantId: product.variantId || null,
                    name: product.name,
                    variantName: product.variantName || null,
                    price: product.price,
                    originalPrice: product.originalPrice || product.price,
                    quantity: product.quantity || 1,
                    image: product.image || '/images/default-product.jpg',
                    slug: product.slug || '',
                    stock: product.stock || 0,
                    hasDiscount: product.hasDiscount || false,
                    discountPercentage: product.discountPercentage || 0
                };
                
                cart.push(cartItem);
            }

            this.saveCartItems(cart);
            return true;
        } catch (error) {
            console.error('Error adding to cart:', error);
            return false;
        }
    },

    /**
     * Menghapus item dari keranjang
     * @param {string} cartItemId - Cart item ID
     */
    removeFromCart(cartItemId) {
        try {
            let cart = this.getCartItems();
            cart = cart.filter(item => item.cartItemId !== cartItemId);
            this.saveCartItems(cart);
        } catch (error) {
            console.error('Error removing from cart:', error);
        }
    },

    /**
     * Update quantity item di keranjang
     * @param {string} cartItemId - Cart item ID
     * @param {number} quantity - New quantity
     */
    updateQuantity(cartItemId, quantity) {
        try {
            const cart = this.getCartItems();
            const itemIndex = cart.findIndex(item => item.cartItemId === cartItemId);
            
            if (itemIndex > -1) {
                // Pastikan quantity tidak melebihi stock
                const maxQty = cart[itemIndex].stock || 999;
                cart[itemIndex].quantity = Math.min(Math.max(1, parseInt(quantity) || 1), maxQty);
                this.saveCartItems(cart);
            }
        } catch (error) {
            console.error('Error updating quantity:', error);
        }
    },

    /**
     * Menghitung total harga keranjang
     * @returns {number} Total price
     */
    getCartTotal() {
        const cart = this.getCartItems();
        return cart.reduce((total, item) => {
            return total + (item.price * item.quantity);
        }, 0);
    },

    /**
     * Menghitung jumlah total item di keranjang
     * @returns {number} Total item count
     */
    getCartCount() {
        const cart = this.getCartItems();
        return cart.reduce((count, item) => count + item.quantity, 0);
    },

    /**
     * Mengosongkan keranjang
     */
    clearCart() {
        try {
            localStorage.removeItem(this.STORAGE_KEY);
            this.updateCartBadge();
            this.dispatchCartUpdateEvent();
        } catch (error) {
            console.error('Error clearing cart:', error);
        }
    },

    /**
     * Update cart badge di header (jika ada)
     */
    updateCartBadge() {
        const count = this.getCartCount();
        
        // Update desktop badge
        const badge = document.getElementById('cart-badge');
        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'flex' : 'none';
        }
        
        // Update mobile badge
        const badgeMobile = document.getElementById('cart-badge-mobile');
        if (badgeMobile) {
            badgeMobile.textContent = count;
            badgeMobile.style.display = count > 0 ? 'flex' : 'none';
        }
    },

    /**
     * Dispatch custom event ketika cart berubah
     */
    dispatchCartUpdateEvent() {
        const event = new CustomEvent('cartUpdated', {
            detail: {
                items: this.getCartItems(),
                count: this.getCartCount(),
                total: this.getCartTotal()
            }
        });
        window.dispatchEvent(event);
    },

    /**
     * Format angka ke format Rupiah
     * @param {number} amount - Amount to format
     * @returns {string} Formatted price
     */
    formatPrice(amount) {
        return 'Rp ' + parseInt(amount).toLocaleString('id-ID');
    },

    /**
     * Show notification/toast message
     * @param {string} message - Message to show
     * @param {string} type - Type of notification (success, error, info)
     */
    showNotification(message, type = 'success') {
        // Buat toast notification
        const toast = document.createElement('div');
        
        // Style inline untuk memastikan tampil dengan benar
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: ${type === 'success' ? '#10b981' : '#ef4444'};
            color: white;
            padding: 16px 24px;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            z-index: 9999;
            font-size: 14px;
            font-weight: 500;
            max-width: 350px;
            animation: slideInRight 0.3s ease-out;
        `;
        
        // Set content
        toast.innerHTML = `
            <div style="display: flex; align-items: center; gap: 10px;">
                ${type === 'success' 
                    ? '<svg style="width: 20px; height: 20px; flex-shrink: 0;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>'
                    : '<svg style="width: 20px; height: 20px; flex-shrink: 0;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>'
                }
                <span>${message}</span>
            </div>
        `;
        
        // Tambahkan ke body
        document.body.appendChild(toast);
        
        // Hapus setelah 3 detik dengan animasi
        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease-out';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 300);
        }, 3000);
    }
};

// Export untuk digunakan di file lain
window.CartManager = CartManager;

// Initialize cart badge ketika halaman load
document.addEventListener('DOMContentLoaded', function() {
    CartManager.updateCartBadge();
});

