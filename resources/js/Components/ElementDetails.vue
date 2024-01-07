<script setup>
import { ref, computed } from "vue";

const { details } = defineProps({
    details: String,
});

let show_view = ref(false);
</script>

<template>
    <div
        @mouseover="show_view = !show_view"
        @mouseout="show_view = !show_view"
        class="relative w-fit"
    >
        <slot></slot>
        <span
            v-if="show_view"
            class="absolute top-10 left-0 bg-blue-50 px-3 py-1 shadow-lg text-center translate-x-[-25%] z-10 whitespace-nowrap"
            >{{ details }}
        </span>
    </div>
</template>
