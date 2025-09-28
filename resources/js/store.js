import { reactive, computed } from 'vue';
export const cart = reactive({
    items: [],

    add(product) {
        const existingItem = this.items.find(item => item.id === product.id);
        if (existingItem) {
            existingItem.quantity++;
        } else {
            this.items.push({ ...product, quantity: 1 });
        }
    },

    remove(productId) {
        this.items = this.items.filter(item => item.id !== productId);
    },

    increaseQuantity(productId) {
        const item = this.items.find(item => item.id === productId);
        if (item) {
            item.quantity++;
        }
    },

    decreaseQuantity(productId) {
        const item = this.items.find(item => item.id === productId);
        if (item && item.quantity > 1) {
            item.quantity--;
        } else if (item && item.quantity === 1) {
            this.remove(productId);
        }
    },

    totalItems: computed(() => {
        return cart.items.reduce((sum, item) => sum + item.quantity, 0);
    }),

    total: computed(() => {
        return cart.items.reduce((sum, item) => {
            const price = parseFloat(item.price) || 0;
            return sum + (price * item.quantity);
        }, 0);
    }),
});
