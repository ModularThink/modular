<template>
    <div
        class="border-neutral-4 bg-neutral-2 hover:bg-neutral-3 flex items-center rounded-lg border p-4 shadow-2xs transition-all duration-300 hover:cursor-pointer"
        @click="router.visit(route(link))"
    >
        <div class="mr-4 rounded-full px-3 py-2" :class="color">
            <i :class="icon" class="text-2xl"></i>
        </div>
        <div>
            <p class="mb-2 font-semibold">
                {{ label }}
            </p>
            <p>
                {{ count }}
            </p>
        </div>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'

defineProps({
    link: {
        type: String,
        default: null
    },
    count: {
        type: Number,
        default: null
    },
    label: {
        type: String,
        default: null
    },
    icon: {
        type: String,
        default: null
    },
    color: {
        type: String,
        default: 'info',
        validator: (value) => {
            return ['info', 'success', 'warning', 'danger'].includes(value)
        }
    }
})
</script>

<style scoped>
@reference "../../../../css/app.css";

.info {
    @apply bg-info-light text-info;
}

.success {
    @apply bg-success-light text-success;
}

.warning {
    @apply bg-warning-light text-warning;
}

.danger {
    @apply bg-error-light text-error;
}
</style>
