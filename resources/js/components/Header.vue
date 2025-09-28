<template>
    <header class="bg-white shadow-sm">
        <nav class="navbar navbar-expand-lg navbar-light bg-white container">
            <div class="container-fluid">
                <a class="navbar-brand" href="#" @click.prevent="$emit('navigate', 'products')">
                    <img src="/public/images/logo-bussola-negativo.png" alt="Bússola Logo" height="55">
                </a>

                <a href="#" @click.prevent="$emit('navigate', 'cart')" class="nav-link position-relative">
                    <i class="bi bi-cart fs-4"></i>
                    <span v-if="cart.totalItems > 0" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ cart.totalItems }}
                        <span class="visually-hidden">itens no carrinho</span>
                    </span>
                </a>
            </div>
        </nav>
    </header>
</template>

<script setup>
import { cart } from '../store.js';
defineEmits(['navigate']);
</script>
