<template>
    <div class="bg-gray-100 min-h-screen">
        <Header @navigate="navigateTo" />

        <main>
            <ProductListPage v-if="currentPage === 'products'" />
            <CartPage v-else-if="currentPage === 'cart'" @navigate="navigateTo" />
        </main>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import Header from './Header.vue';
import ProductListPage from './ProductListPage.vue';
import CartPage from './CartPage.vue';

const currentPage = ref('products');

const navigateTo = (page) => {
    currentPage.value = page;
};
</script>
