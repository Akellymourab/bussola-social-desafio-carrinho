<template>
    <div class="container py-5">
        <h2 class="fw-bold mb-4">Nossos Produtos</h2>
        <div v-if="isLoading" class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
        </div>
        <div v-else class="row g-4">
            <div v-for="product in products" :key="product.id" class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold">{{ product.name }}</h5>
                        <p class="card-text fs-4 my-2">R$ {{ parseFloat(product.price).toFixed(2) }}</p>
                        <button @click="cart.add(product)" class="btn btn-primary mt-auto">
                            <i class="bi bi-cart-plus"></i> Adicionar ao Carrinho
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { cart } from '../store.js';

const products = ref([]);
const isLoading = ref(true);
const apiUrl = import.meta.env.VITE_API_URL;

onMounted(async () => {
    try {
        const response = await axios.get(`${apiUrl}/products`);
        products.value = response.data;
    } catch (error) {
        console.error("Erro ao buscar produtos:", error);
    } finally {
        isLoading.value = false;
    }
});
</script>
