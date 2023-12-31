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
        class="w-full h-screen absolute top-0 left-0 px-10 py-5 bg-black bg-opacity-70 flex items-center justify-center"
    >
        <div class="bg-white rounded-md px-10 py-6">
            <!-- event details -->
            <div class="flex flex-col justify-between items-center gap-5">
                <h2 class="text-lg font-semibold text-center whitespace-normal">
                    {{ title }}
                </h2>
                <div
                    class="cursor-pointer flex items-center justify-center gap-2"
                >
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>
