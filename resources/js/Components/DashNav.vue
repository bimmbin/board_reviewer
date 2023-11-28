<script setup>
import { ref, computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    image: {
        type: String,
    },
    nav_name: {
        type: String,
    },
    href: {
        type: String,
    },
    active: {
        type: Boolean,
    },
    route_name: {
        type: String,
    },
});
const classes = computed(() =>
    props.active
        ? "active:bg-blue-300 hover:bg-hover_bg bg-hover_bg text-white flex items-center gap-3 hover:bg-gray2 px-10 py-3 bg-gray3 bg-opacity-500 border-l-4 border-white"
        : "active:bg-blue-300 hover:bg-hover_bg text-white flex items-center gap-3 hover:bg-gray2 px-10 py-3"
);
const img_path = ref("/img/");
</script>

<template>
    <Link :href="href" :class="classes">
        <img :src="img_path + image + '.svg'" class="w-4 h-4" />
        <span class="text-lg whitespace-nowrap max-sm:text-base">{{
            nav_name
        }}</span>
    </Link>
</template>
