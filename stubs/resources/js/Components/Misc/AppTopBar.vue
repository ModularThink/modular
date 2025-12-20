<template>
    <div
        class="sticky top-0 z-40 flex h-16 flex-shrink-0 justify-between bg-skin-neutral-2 py-3 pl-3 pr-4 text-skin-neutral-11 shadow-sm md:pr-6"
    >
        <div class="flex items-center">
            <AppButton
                class="btn btn-icon hover:bg-skin-neutral-5"
                @click="$emit('sidebar:toggle')"
            >
                <i class="ri-menu-line"></i>
            </AppButton>

            <h1 class="flex items-center">{{ title }}</h1>
        </div>

        <div class="flex items-center gap-1">
            <!-- Fullscreen toggle with animation -->
            <AppButton
                class="btn btn-icon hover:bg-skin-neutral-5 transition-all duration-300"
                @click="toggleFullscreen"
            >
                <i
                    :class="iconFullscreenClass"
                    class="transition-transform duration-500 ease-in-out"
                    :style="{
                        transform: isFullscreen
                            ? 'rotate(180deg) scale(1.2)'
                            : 'rotate(0deg) scale(1)'
                    }"
                ></i>
            </AppButton>

            <!-- Theme toggle -->
            <AppButton
                href="#"
                class="btn btn-icon hover:bg-skin-neutral-5 transition-all duration-300"
                @click="toggleTheme"
            >
                <i :class="iconThemeClass"></i>
            </AppButton>

            <!-- Logout -->
            <AppButton
                class="btn btn-icon hover:bg-skin-neutral-5"
                @click="$inertia.visit(route('adminAuth.logout'))"
            >
                <i class="ri-logout-circle-r-line"></i>
            </AppButton>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

defineProps({
    title: {
        type: String,
        default: ''
    }
})

defineEmits(['sidebar:toggle'])

/* ========== THEME ========== */
const iconThemeClass = ref('ri-sun-line')

onMounted(() => {
    if (localStorage.getItem('modular-theme') === 'dark-theme') {
        document.documentElement.classList.add('dark-theme')
        iconThemeClass.value = 'ri-sun-line'
    } else {
        document.documentElement.classList.remove('dark-theme')
        iconThemeClass.value = 'ri-moon-line'
    }
})

const toggleTheme = () => {
    if (document.documentElement.classList.contains('dark-theme')) {
        document.documentElement.classList.remove('dark-theme')
        iconThemeClass.value = 'ri-moon-line'
        localStorage.removeItem('modular-theme')
    } else {
        localStorage.setItem('modular-theme', 'dark-theme')
        document.documentElement.classList.add('dark-theme')
        iconThemeClass.value = 'ri-sun-line'
    }
}

/* ========== FULLSCREEN ========== */
const isFullscreen = ref(false)
const iconFullscreenClass = ref('ri-fullscreen-line')

const toggleFullscreen = () => {
    if (!isFullscreen.value) {
        document.documentElement.requestFullscreen()
    } else {
        document.exitFullscreen()
    }
}

const updateFullscreenState = () => {
    isFullscreen.value = !!document.fullscreenElement
    iconFullscreenClass.value = isFullscreen.value
        ? 'ri-fullscreen-exit-line'
        : 'ri-fullscreen-line'

    // Persist fullscreen state
    localStorage.setItem('fullscreen', isFullscreen.value ? '1' : '0')
}

onMounted(() => {
    document.addEventListener('fullscreenchange', updateFullscreenState)

    // Restore fullscreen if previously enabled
    if (localStorage.getItem('fullscreen') === '1') {
        document.documentElement.requestFullscreen().catch(() => {})
    }
})

onUnmounted(() => {
    document.removeEventListener('fullscreenchange', updateFullscreenState)
})
</script>
