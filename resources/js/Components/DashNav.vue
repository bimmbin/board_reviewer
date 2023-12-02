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
    sub_nav: {
        type: Boolean,
    },
});
const classes = computed(() =>
    props.active
        ? "active:bg-blue-300 hover:bg-hover_bg bg-hover_bg flex gap-2 text-white hover:bg-gray2 px-10 py-3 bg-gray3 bg-opacity-500 border-l-4 border-white select-none"
        : "active:bg-blue-300 hover:bg-hover_bg text-white flex gap-2 hover:bg-gray2 px-10 py-3 select-none"
);
const img_path = ref("/img/");
</script>

<template>
    <Link :href="href" :class="classes">
        <div v-if="sub_nav" class="w-5"></div>
        <div class="flex items-center gap-3">
            <img :src="img_path + image + '.svg'" class="w-4 h-4" />
            <span class="text-lg whitespace-nowrap max-sm:text-base">{{
                nav_name
            }}</span>
        </div>
    </Link>
</template>
