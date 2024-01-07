<script setup>
import { ref } from "vue";

const { title, width, warning } = defineProps({
    title: String,
    warning: String,
    width: String,
});

const emit = defineEmits(["close_dialog"]);

const exit = ref("/img/exit.svg");
</script>

<template>
      <div
        class="w-full h-screen absolute top-0 left-0 px-10 py-5 bg-black bg-opacity-70 flex items-center justify-center z-10 normal-case"
    >
        <div class="bg-white rounded-md px-10 py-6 " :style="'width:' + width + 'rem'">
            <!-- event details -->
            <div class="flex flex-col justify-between items-center gap-2">
                <h2 class="text-xl font-semibold text-center whitespace-normal ">
                    {{ title }}
                </h2>
                <h3 class="text-center text-base">Warning: {{ warning }}</h3>
                <div 
                    class="cursor-pointer flex items-center justify-center gap-2 mt-5"
                >
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>
