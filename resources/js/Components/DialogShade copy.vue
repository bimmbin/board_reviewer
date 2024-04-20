<script setup>
import { ref } from "vue";

const { title } = defineProps({
    title: String,
});

const emit = defineEmits(["close_dialog"]);

const exit = ref("/img/exit.svg");
</script>

<template>
    <div
        class="absolute top-0 left-0 flex items-center justify-center w-full h-screen px-10 py-5 bg-black cursor-default bg-opacity-70"
    >
        <div
            class="w-[900px] mx-auto max-2xl:w-[800px] max-xl:w-[700px] max-md:w-screen max-md:px-5 py-5 max-sm:py-0 text-black max-xl:px-10 bg-blue-100 rounded-xl px-5"
        >
            <!-- event details -->
            <div
                class="flex flex-col items-center justify-between w-full gap-5"
            >
                <div class="flex items-center justify-between w-full">
                    <h1 class="text-xl font-semibold text-blue-800">
                        {{ title }}
                    </h1>
                    <img :src="exit" @click="$emit('close_dialog')" />
                </div>
            </div>
            <slot></slot>
        </div>
    </div>
</template>
