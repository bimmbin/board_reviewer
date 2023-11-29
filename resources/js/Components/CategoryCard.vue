<script setup>
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps({
    category: {
        type: Object,
        required: true,
    },
});
const lesson_icon = ref("/img/lesson_icon.svg");
</script>

<template>
    <Link :href="route('test.index', [category.id, 1])"
        class="w-[550px] px-6 py-4  bg-gradient-to-r from-blue-600 to-blue-400 max-2xl:w-[450px] max-xl:w-full h-52 max-sm:h-40 bg-gray2 flex flex-col justify-between rounded-xl"
    >
        <div class="w-full h-full flex flex-col justify-between">
            <img :src="lesson_icon" alt="" class="w-12" />
            <div class="flex items-center">
                <h2 class="text-white text-2xl font-light">
                    {{ category.category_name }}
                </h2>
            </div>
        </div>
    </Link>
</template>
