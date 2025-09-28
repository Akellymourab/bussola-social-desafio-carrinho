<template>
    <div class="container py-5">
        <div v-if="cart.items.length > 0" class="row g-5">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-4">Seu Carrinho</h2>
                <div v-for="item in cart.items" :key="item.id" class="d-flex align-items-center p-3 mb-3 cart-item-card">
                    <div class="bg-light rounded flex-shrink-0" style="width: 100px; height: 100px;"></div>
                    <div class="flex-grow-1 ms-4">
                        <h5 class="fw-bold">{{ item.name }}</h5>
                        <p class="fw-bold mb-2">R$ {{ parseFloat(item.price).toFixed(2) }}</p>
                        <div class="input-group" style="max-width: 150px;">
                            <button @click="cart.decreaseQuantity(item.id)" class="btn btn-outline-secondary">-</button>
                            <span class="input-group-text bg-white">{{ item.quantity }}</span>
                            <button @click="cart.increaseQuantity(item.id)" class="btn btn-outline-secondary">+</button>
                        </div>
                    </div>
                    <button @click="cart.remove(item.id)" class="btn btn-link text-danger fs-4">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="summary-box">
                    <h3 class="fw-bold mb-4">Resumo do Pedido</h3>

                    <div class="mb-3">
                        <label for="paymentMethod" class="form-label">Forma de Pagamento</label>
                        <select id="paymentMethod" class="form-select" v-model="paymentMethod">
                            <option value="pix">Pix</option>
                            <option value="credit_card">Cartão de Crédito</option>
                        </select>
                    </div>

                    <div v-if="paymentMethod === 'credit_card'" class="mb-4">
                        <label for="installments" class="form-label">Parcelas</label>
                        <select id="installments" class="form-select" v-model="installments">
                            <option value="1">1x (à vista com 10% de desconto)</option>
                            <option v-for="i in 11" :key="i + 1" :value="i + 1">
                                {{ i + 1 }}x com juros
                            </option>
                        </select>
                    </div>

                    <hr>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-2">
                            Subtotal
                            <span>R$ {{ cart.total.toFixed(2) }}</span>
                        </li>
                        <li v-if="discount > 0" class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-2 text-success">
                            Desconto
                            <span>- R$ {{ discount.toFixed(2) }}</span>
                        </li>
                        <li v-if="interest > 0" class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-2 text-danger">
                            Juros
                            <span>+ R$ {{ interest.toFixed(2) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pt-3">
                            <strong class="fs-5">Total</strong>
                            <strong class="fs-5">R$ {{ finalTotal.toFixed(2) }}</strong>
                        </li>
                    </ul>
                    <div v-if="paymentMethod === 'credit_card' && installments > 1" class="text-end text-muted small mt-2">
                        Total em {{ installments }}x de R$ {{ (finalTotal / installments).toFixed(2) }}
                    </div>

                    <button class="btn btn-primary w-100 mt-4 py-2" @click="handleCheckout" :disabled="isLoading">
                        <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span v-else>Finalizar Compra</span>
                    </button>
                </div>
            </div>
        </div>

        <div v-else class="text-center py-5">
            <i class="bi bi-cart-x" style="font-size: 5rem; color: #E0E0E0;"></i>
            <h3 class="mt-4">Seu carrinho está vazio.</h3>
            <p class="text-muted">Adicione produtos para vê-los aqui.</p>
            <button @click="$emit('navigate', 'products')" class="btn btn-primary mt-3">
                Ver Produtos
            </button>
        </div>

        <CheckoutModal v-if="showModal" :show="showModal" :data="checkoutData" @close="showModal = false" />
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { cart } from '../store.js';
import CheckoutModal from './CheckoutModal.vue';
import apiClient from '../api.js';

defineEmits(['navigate']);

const paymentMethod = ref('pix');
const installments = ref(1);

const discount = computed(() => {
    if (paymentMethod.value === 'pix' || (paymentMethod.value === 'credit_card' && installments.value === 1)) {
        return cart.total * 0.10;
    }
    return 0;
});
const interest = computed(() => {
    if (paymentMethod.value === 'credit_card' && installments.value > 1) {
        const M = cart.total * Math.pow((1 + 0.01), installments.value);
        return M - cart.total;
    }
    return 0;
});
const finalTotal = computed(() => {
    return cart.total - discount.value + interest.value;
});

const isLoading = ref(false);
const showModal = ref(false);
const checkoutData = ref(null);

async function handleCheckout() {
    isLoading.value = true;

    const paymentMethodApi = paymentMethod.value === 'pix' ? 'PIX' : 'CARTAO_CREDITO';

    const payload = {
        products: cart.items.map(item => ({
            name: item.name,
            price: parseFloat(item.price),
            quantity: item.quantity
        })),
        payment_method: paymentMethodApi,
        installments: installments.value,
    };

    try {
        const response = await apiClient.post('/cart/calculate', payload);

        if (typeof response.data.price_total !== 'number') {
            throw new Error("Formato de resposta da API inválido.");
        }

        checkoutData.value = {
            finalTotal: response.data.price_total,
            installments: installments.value,
            installmentValue: installments.value > 0 ? response.data.price_total / installments.value : 0,
        };
        showModal.value = true;
    } catch (error) {
        console.error("Erro ao finalizar a compra:", error.response?.data || error.message);
        alert("Não foi possível validar seu carrinho. Tente novamente.");
    } finally {
        isLoading.value = false;
    }
}
</script>
