<template>
    <div ref="wrapperRef" class="relative w-64">
        <!-- Button to open dropdown -->
        <AppButton
            class="mt-1 flex w-full flex-wrap justify-between rounded-md border-0 bg-skin-neutral-1 px-3 py-2 text-left text-skin-neutral-12 shadow-sm ring-1 ring-inset ring-skin-neutral-7 focus:ring-2 focus:ring-inset focus:ring-skin-neutral-7 sm:text-sm sm:leading-6"
            aria-haspopup="true"
            :aria-expanded="isOpen"
            @click="toggleState"
        >
            <!-- Selected tags -->
            <div class="flex flex-wrap gap-1">
                <span
                    v-for="(item, index) in modelValue"
                    :key="item.value"
                    class="flex items-center rounded bg-skin-neutral-3 px-2 py-1 text-xs text-skin-neutral-12"
                >
                    {{ item.label }}
                    <i
                        class="ri-close-line ml-1 cursor-pointer hover:text-red-500"
                        @click.stop="remove(index)"
                    />
                </span>

                <span v-if="!modelValue.length" class="text-skin-neutral-9">
                    {{ comboLabel }}
                </span>
            </div>

            <span class="ml-auto">
                <i class="ri-arrow-down-line hover:text-skin-neutral-9"></i>
            </span>
        </AppButton>

        <!-- Dropdown -->
        <transition name="slide-fade">
            <div v-show="isOpen" class="absolute z-50 mt-1 w-full">
                <!-- Search -->
                <div v-show="useSearch" class="bg-white p-1 shadow">
                    <label :for="getElementId()" class="sr-only">Search</label>
                    <div class="relative">
                        <div
                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                        >
                            <i class="ri-search-line" aria-hidden="true"></i>
                        </div>
                        <AppInputText
                            :id="getElementId()"
                            ref="searchInputRef"
                            v-model="searchOptionText"
                            role="searchbox"
                            aria-autocomplete="list"
                            type="text"
                            class="pl-10"
                            :placeholder="searchPlaceholder"
                            @keypress.enter="validateOptionHighlighted"
                            @keydown="handleArrowKeys"
                            @keydown.esc="toggleState"
                        />
                    </div>
                </div>

                <!-- Options -->
                <ul
                    class="max-h-60 overflow-y-auto bg-white p-1 shadow"
                    role="listbox"
                >
                    <li
                        v-for="(option, index) in filteredOptions"
                        :key="option.value"
                        role="option"
                        class="flex items-center gap-2 px-4 py-2 text-sm hover:cursor-pointer hover:bg-skin-neutral-3 hover:text-skin-neutral-12"
                        :class="{
                            'bg-skin-neutral-3 text-skin-neutral-12':
                                index === highlightedIndex
                        }"
                        @click="toggleSelect(option)"
                    >
                        <input
                            type="checkbox"
                            class="rounded border-gray-300"
                            :checked="isSelected(option)"
                            @change="toggleSelect(option)"
                        />
                        {{ option.label }}
                    </li>
                </ul>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import slug from '@resources/js/Utils/slug.js'
import useClickOutside from '@resources/js/Composables/useClickOutside'

const props = defineProps({
    modelValue: {
        type: Array,
        required: true,
        default: () => []
    },
    comboLabel: {
        type: String,
        default: 'Select options'
    },
    useSearch: {
        type: Boolean,
        default: true
    },
    searchPlaceholder: {
        type: String,
        default: 'Search'
    },
    options: {
        type: Array,
        default: () => []
    }
})

const emit = defineEmits(['update:modelValue'])

const wrapperRef = ref(null)
const { isClickOutside } = useClickOutside(wrapperRef)

watch(isClickOutside, (val) => {
    if (val) {
        isOpen.value = false
    }
})

onMounted(() => {
    isOpen.value && (highlightedIndex.value = 0)
})

const getElementId = () => {
    return slug(props.comboLabel)
}

const isOpen = ref(false)
const searchInputRef = ref(null)

const toggleState = () => {
    isOpen.value = !isOpen.value
    highlightedIndex.value = 0
    window.setTimeout(() => {
        if (isOpen.value) {
            searchOptionText.value = ''
            searchInputRef.value.focusInput()
        }
    }, 100)
}

const searchOptionText = ref('')

const filteredOptions = computed(() => {
    if (searchOptionText.value) {
        return props.options.filter((option) =>
            option.label
                .toLowerCase()
                .includes(searchOptionText.value.toLowerCase())
        )
    } else {
        return props.options
    }
})

const highlightedIndex = ref(0)

const handleArrowKeys = (event) => {
    switch (event.key) {
        case 'ArrowUp':
            if (highlightedIndex.value > 0) {
                highlightedIndex.value--
            }
            break
        case 'ArrowDown':
            if (highlightedIndex.value < filteredOptions.value.length - 1) {
                highlightedIndex.value++
            }
            break
    }
}

const validateOptionHighlighted = () => {
    if (filteredOptions.value[highlightedIndex.value]) {
        toggleSelect(filteredOptions.value[highlightedIndex.value])
    }
}

const isSelected = (option) => {
    return props.modelValue.some((item) => item.value === option.value)
}

const toggleSelect = (option) => {
    let newValue
    if (isSelected(option)) {
        newValue = props.modelValue.filter(
            (item) => item.value !== option.value
        )
    } else {
        newValue = [...props.modelValue, option]
    }
    emit('update:modelValue', newValue)
}

const remove = (index) => {
    const newValue = [...props.modelValue]
    newValue.splice(index, 1)
    emit('update:modelValue', newValue)
}
</script>

<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
    @apply transition-all duration-200 ease-in;
}
.slide-fade-enter-from,
.slide-fade-leave-to {
    @apply -translate-y-2 opacity-0;
}
</style>
