<template>
    <div class="modal fade" :class="{ 'show d-block': show }" tabindex="-1" @click.self="$emit('close')">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Resumo da Compra</h5>
                    <button type="button" class="btn-close" @click="$emit('close')"></button>
                </div>
                <div class="modal-body" v-if="data">
                    <p class="text-muted">Compra validada pelo nosso sistema. Por favor, confirme o valor final para pagar.</p>

                    <ul class="list-group list-group-flush mt-3">
                        <li class="list-group-item d-flex justify-content-between fs-5 fw-bold">
                            Total a Pagar
                            <span>R$ {{ data.finalTotal.toFixed(2) }}</span>
                        </li>
                    </ul>

                    <div v-if="data.installments > 1" class="alert alert-info mt-3 text-center">
                        Pagamento em <strong>{{ data.installments }}x</strong> de <strong>R$ {{ data.installmentValue.toFixed(2) }}</strong>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" @click="$emit('close')">Cancelar</button>
                    <button type="button" class="btn btn-primary">Confirmar e Pagar</button>
                </div>
            </div>
        </div>
    </div>
    <div v-if="show" class="modal-backdrop fade show"></div>
</template>

<script setup>
defineProps({
    show: {
        type: Boolean,
        required: true
    },
    data: {
        type: Object,
        default: null
    }
});
defineEmits(['close']);
</script>
