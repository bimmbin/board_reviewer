<script setup>
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    major: {
        type: Object,
        required: true,
    },
});

const drop = ref("/img/drop.svg");
</script>

<template>
    <Link
        
        class="w-[550px] px-6 py-5 bg-gradient-to-r from-blue-600 to-blue-400 max-2xl:w-[450px] max-xl:w-full bg-gray2 flex flex-col justify-between rounded-xl"
    >
        <div class="w-full h-full flex justify-between">
            <h2 class="text-white text-2xl font-light max-md:text-xl">
                {{ props.major.major_name }}
            </h2>
            <img :src="drop" class="-rotate-90">
        </div>
    </Link>
</template>
